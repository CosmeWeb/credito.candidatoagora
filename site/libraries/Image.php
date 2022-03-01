<?php
class Image {
	private $file;
	private $image;
	private $info;

	public function __construct($file = "") {
		if (file_exists($file))
		{
			$this->file = $file;

			$info = getimagesize($file);

			$this->info = array(
				'width'  => $info[0],
				'height' => $info[1],
				'bits'   => isset($info['bits']) ? $info['bits'] : '',
				'mime'   => isset($info['mime']) ? $info['mime'] : ''
			);

			$this->image = $this->create($file);
		}
		else
		{
			//exit('Error: Could not load image ' . $file . '!');
		}
	}
	private function create($image) {
		$mime = $this->info['mime'];

		if ($mime == 'image/gif') {
			return imagecreatefromgif ($image);
		} elseif ($mime == 'image/png') {
			return imagecreatefrompng($image);
		} elseif ($mime == 'image/jpeg') {
			return imagecreatefromjpeg($image);
		}
	}
	public function carrega($image)
	{
		$img = new Image($image);
		return $img;
	}
	public function &GetInstancia()
	{
		return $this;
	}
	public function save($file, $quality = 90) {
		$caminho = dirname($file);
		if (!is_dir($caminho) && strlen($caminho) > 0)
			CriarPastas($caminho, 0777);
		$info = pathinfo($file);

		$extension = strtolower($info['extension']);

		if (is_resource($this->image)) {
			if ($extension == 'jpeg' || $extension == 'jpg') {
				imagejpeg($this->image, $file, $quality);
			} elseif ($extension == 'png') {
				imagepng($this->image, $file);
			} elseif ($extension == 'gif') {
				imagegif ($this->image, $file);
			}

			imagedestroy($this->image);
		}
	}
	public function output() {
		$mime = $this->info['mime'];
		if (is_resource($this->image)){
			if($mime == 'image/gif')
			{
				header("Content-type: image/gif");
				imagegif ($this->image);
			}
			elseif($mime == 'image/png')
			{
				header("Content-type: image/png");
				imagepng($this->image);
			}
			elseif(($mime == 'image/jpeg')||($mime == 'image/jpg'))
			{
				header("Content-type: image/jpeg");
				imagejpeg($this->image, NULL, 100);
			}
			imagedestroy($this->image);
		}
	}
	public function resize($width = 0, $height = 0, $default = '', $escala = 0.4) {
		if (!$this->info['width'] || !$this->info['height']) {
			return;
		}

		$xpos = 0;
		$ypos = 0;
		$scale = 1;
		if(($width <= 0)&&($height <= 0))
		{
			$width = intval($this->info['width'] * $escala);
			$height = intval($this->info['height'] * $escala);
		}
		if($width <= 0)
		{
			$width = ($this->info['width'] * $height) / $this->info['height'];
		}
		if($height <= 0)
		{
			$height = ($this->info['height'] * $width) / $this->info['width'];
		}
		$scale_w = $width / $this->info['width'];
		$scale_h = $height / $this->info['height'];

		if ($default == 'w') {
			$scale = $scale_w;
		} elseif ($default == 'h') {
			$scale = $scale_h;
		} else {
			$scale = min($scale_w, $scale_h);
		}

		if ($scale == 1 && $scale_h == $scale_w && $this->info['mime'] != 'image/png') {
			return;
		}

		$new_width = (int)($this->info['width'] * $scale);
		$new_height = (int)($this->info['height'] * $scale);
		$xpos = (int)(($width - $new_width) / 2);
		$ypos = (int)(($height - $new_height) / 2);

		$image_old = $this->image;
		$this->image = imagecreatetruecolor($width, $height);

		if (isset($this->info['mime']) && $this->info['mime'] == 'image/png') {
			imagealphablending($this->image, false);
			imagesavealpha($this->image, true);
			$background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
			imagecolortransparent($this->image, $background);
		} else {
			$background = imagecolorallocate($this->image, 255, 255, 255);
		}

		imagefilledrectangle($this->image, 0, 0, $width, $height, $background);

		imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
		imagedestroy($image_old);

		$this->info['width']  = $width;
		$this->info['height'] = $height;
	}
	public function watermark($file, $position = 'bottomright') {
		$watermark = $this->create($file);

		$watermark_width = imagesx($watermark);
		$watermark_height = imagesy($watermark);

		switch($position) {
			case 'topleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = 0;
				break;
			case 'topright':
				$watermark_pos_x = $this->info['width'] - $watermark_width;
				$watermark_pos_y = 0;
				break;
			case 'bottomleft':
				$watermark_pos_x = 0;
				$watermark_pos_y = $this->info['height'] - $watermark_height;
				break;
			case 'bottomright':
				$watermark_pos_x = $this->info['width'] - $watermark_width;
				$watermark_pos_y = $this->info['height'] - $watermark_height;
				break;
		}

		imagecopy($this->image, $watermark, $watermark_pos_x, $watermark_pos_y, 0, 0, 120, 40);

		imagedestroy($watermark);
	}
	public function crop($top_x, $top_y, $bottom_x, $bottom_y) {
		$image_old = $this->image;
		$this->image = imagecreatetruecolor($bottom_x - $top_x, $bottom_y - $top_y);

		imagecopy($this->image, $image_old, 0, 0, $top_x, $top_y, $this->info['width'], $this->info['height']);
		imagedestroy($image_old);

		$this->info['width'] = $bottom_x - $top_x;
		$this->info['height'] = $bottom_y - $top_y;
	}
	public function rotate($degree, $color = 'FFFFFF') {
		$rgb = $this->html2rgb($color);

		$this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));

		$this->info['width'] = imagesx($this->image);
		$this->info['height'] = imagesy($this->image);
	}
	private function filter($filter) {
		imagefilter($this->image, $filter);
	}
	private function text($text, $x = 0, $y = 0, $size = 5, $color = '000000') {
		$rgb = $this->html2rgb($color);

		imagestring($this->image, $size, $x, $y, $text, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
	}
	private function merge($file, $x = 0, $y = 0, $opacity = 100) {
		$merge = $this->create($file);

		$merge_width = imagesx($merge);
		$merge_height = imagesy($merge);

		imagecopymerge($this->image, $merge, $x, $y, 0, 0, $merge_width, $merge_height, $opacity);
	}
	private function html2rgb($color) {
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}

		if (strlen($color) == 6) {
			list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
		} elseif (strlen($color) == 3) {
			list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
		} else {
			return false;
		}

		$r = hexdec($r);
		$g = hexdec($g);
		$b = hexdec($b);

		return array($r, $g, $b);
	}
	public function GetAltura() {
		return $this->info['height'];
	}
	public function GetLargura() {
		return $this->info['width'];
	}
	public function GeraIcone($nome = "")
	{
		if($this->GetAltura() >= $this->GetLargura())
			$this->resize(0, 39,"h");
		else
			$this->resize(39, 0,"w");
		$x = $this->GetLargura();
		if($x<39)
		{
			$xbaixo = $x;
			$x = 0;
		}
		else
		{
			$x = (int) round (($x-39)/2, 0);
			$xbaixo = $x+39;
		}
		$y = $this->GetLargura();
		if($y<39)
		{
			$ybaixo = $y;
			$y = 0;
		}
		else
		{
			$y = (int) round (($y-39)/2, 0);
			$ybaixo = $y+39;
		}
		$this->crop($x,$y,$xbaixo,$ybaixo);
		$file = Opcoes::SetDominio("/anuncios/esqueleto-anuncio/icone/pineditavel.png");
		$merge = $this->carrega($file);

		$merge_width = imagesx($merge);
		$merge_height = imagesy($merge);
		$x = $this->GetLargura();
		if($x<39)
		{
			$x = (int) round ((39-$x)/2, 0);
			$x = 12 + $x ;
		}
		else
		{
			$x = 12;
		}
		$y = $this->GetLargura();
		if($y<39)
		{
			$y = (int) round ((39-$y)/2, 0);
			$y = 3+y;
		}
		else
		{
			$y = 3;
		}
		$dst_img = imagecreatetruecolor($merge_width, $merge_width);
		imagealphablending($dst_img, false);
		imagesavealpha($dst_img, true);
		$background = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
		imagecolortransparent($dst_img, $background);
		imagefilledrectangle($dst_img, 0, 0, $merge_width, $merge_width, $background);
		imagecopy( $dst_img, $merge, 0, 0, 0, 0, $merge_width, $merge_width);

		$this->GeraCirculo(39,39);

		imagecopymerge( $dst_img, $this->image, $x, $y, 0, 0, $this->GetLargura(), $this->GetLargura(),100);
		
		$this->image = $dst_img;
		$this->save($nome,100);
		return true;
	}
	public function GeraCirculo($w = 640, $h=480)
	{
		$src = $this->image;
	    $newpic = imagecreatetruecolor($w,$h);
	    imagealphablending($newpic,false);
	    imagesavealpha($newpic, true);
	    $transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);
	    imagecolortransparent($newpic, $transparent);
	    $r=$w/2;
	    for($x=0;$x<$w;$x++)
	        for($y=0;$y<$h;$y++){
	            $c = imagecolorat($src,$x,$y);
	            $_x = $x - $w/2;
	            $_y = $y - $h/2;
	            if((($_x*$_x) + ($_y*$_y)) < ($r*$r)){
	                imagesetpixel($newpic,$x,$y,$c);
	            }else{
	                imagesetpixel($newpic,$x,$y,$transparent);
	            }
	        }
	    imagesavealpha($newpic, true);
	    $this->image = $newpic;
	}

}
