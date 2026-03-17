<?php

// Config
$config   = pwConfig::load('pwhero');
$settings = $config['content'];

// Custom Background
if ($block->content()->theme()->value() === 'custom'):
	snippet('customcss', [
		'blockid' => 'b'.$block->id(),
		'textcolor' => $block->content()->textcolor()->value(),
		'backgroundcolor' => $block->content()->backgroundcolor()->value()
	]);
endif;

// Section
echo '<section';
echo ' data-block="hero"';
echo ' data-block-id="b'.$block->id().'"';
echo ' data-margin-top="'.$block->margintop()->value().'"';
echo ' data-margin-bottom="'.$block->marginbottom()->value().'"';
echo ' data-padding-top="'.$block->paddingtop()->value().'"';
echo ' data-padding-right="'.$block->paddingright()->value().'"';
echo ' data-padding-bottom="'.$block->paddingbottom()->value().'"';
echo ' data-padding-left="'.$block->paddingleft()->value().'"';
echo ' data-radius-top-left="'.$block->radiustopleft()->value().'"';
echo ' data-radius-top-right="'.$block->radiustopright()->value().'"';
echo ' data-radius-bottom-right="'.$block->radiusbottomright()->value().'"';
echo ' data-radius-bottom-left="'.$block->radiusbottomleft()->value().'"';
echo ' data-style="'.$block->theme()->value().'"';
echo ' data-block-size="'.$block->blocksize()->value().'"';
echo ' data-background-type="'.$block->backgroundtype()->value().'"';
echo ' data-height="'.$block->height()->value().'"';
e(!empty($settings['buttons']) && $block->content()->theme()->value() === 'custom' && $block->buttonstyle()->value() !== 'default', ' data-button-style="' . $block->buttonstyle()->value() . '"');
echo $block->fragment()->isNotEmpty() ? ' id="'.$block->fragment()->value().'"' : '';
$backgroundType = $block->backgroundtype()->value();
$blur = ($backgroundType === 'image') ? intval($block->blurimage()->value()) : (($backgroundType === 'video') ? intval($block->blurvideo()->value()) : 0);
if ($blur > 0) echo ' data-blur style="--blur-amount:'.$blur.'px"';
echo '>'."\n";

// Background Image
if ($block->backgroundtype()->value() === 'image' && $block->image()->isNotEmpty()):
	$file = $block->image()->toFiles()->first();
	if ($file):
		$focus = $file->focus()->isNotEmpty() ? $file->focus()->value() : '50% 50%';
		$srcset = $file->srcset([480, 720, 960, 1280, 1920]);
		echo '<img data-field="background-image"';
		echo ' src="'.$file->thumb(['width' => 1920, 'quality' => 90, 'format' => 'webp'])->url().'"';
		echo ' srcset="'.$srcset.'"';
		echo ' sizes="100vw"';
		echo ' alt=""';
		echo ' role="presentation"';
		echo ' loading="eager"';
		echo ' style="object-position:'.$focus.'"';
		echo '>'."\n";
	endif;
endif;

// Background Video
if ($block->backgroundtype()->value() === 'video' && $block->video()->isNotEmpty()):
	$file = $block->video()->toFiles()->first();
	if ($file):
		echo '<video data-field="background-video" autoplay muted loop playsinline';
		echo ' src="'.$file->url().'"';
		echo '></video>'."\n";
	endif;
endif;

// Overlay
$overlayType = $block->overlaytype()->value();
if ($overlayType === 'solid') {
	$intensity = intval($block->overlayintensity()->value()) / 100;
	echo '<div data-overlay="solid" style="--overlay-intensity:'.$intensity.'"></div>'."\n";
} elseif ($overlayType === 'gradient') {
	$intensity = intval($block->overlaygradientintensity()->value()) / 100;
	echo '<div data-overlay="gradient"';
	echo ' data-overlay-size="'.$block->overlaysize()->value().'"';
	echo ' data-overlay-position="'.$block->overlayposition()->value().'"';
	echo ' style="--overlay-intensity:'.$intensity.'"';
	echo '></div>'."\n";
}

// Grid
echo '<div data-layout="grid"><div data-layout="grid-item"';
echo ' data-grid-size-sm="'.$block->gridsizesm()->value().'"';
echo ' data-grid-size-md="'.$block->gridsizemd()->value().'"';
echo ' data-grid-size-lg="'.$block->gridsizelg()->value().'"';
echo ' data-grid-size-xl="'.$block->gridsizexl()->value().'"';
echo ' data-grid-offset-sm="'.$block->gridoffsetsm()->value().'"';
echo ' data-grid-offset-md="'.$block->gridoffsetmd()->value().'"';
echo ' data-grid-offset-lg="'.$block->gridoffsetlg()->value().'"';
echo ' data-grid-offset-xl="'.$block->gridoffsetxl()->value().'"';
echo '>'."\n";

// Content wrapper with positioning
echo '<div data-field="contents"';
echo ' data-h="'.$block->positionhorizontal()->value().'"';
echo ' data-v="'.$block->positionvertical()->value().'"';
echo '>'."\n";

// Tagline
if (!empty($settings['tagline'])):
	snippet('tagline', ['content' => $block]);
endif;

// Heading
if (!empty($settings['heading'])):
	snippet('heading', ['content' => $block]);
endif;

// Editor
if (!empty($settings['editor'])):
	snippet('editor', ['content' => $block]);
endif;

// Buttons
if (!empty($settings['buttons'])):
	snippet('buttons', ['content' => $block]);
endif;

echo '</div>'."\n"; // End contents
echo '</div></div>'."\n"; // End Grid
echo '</section>'."\n";
