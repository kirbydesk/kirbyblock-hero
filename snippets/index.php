<?php

// Config
$config   = pwConfig::load('pwhero');
$settings = $config['content'];

// Custom Background
pwSnippet::customCss($block);

// Hero-specific extra attributes for <section>: background-type, height,
// optional blur (only when image/video background + non-zero blur).
$backgroundType = $block->backgroundtype()->value();
$blur = ($backgroundType === 'image') ? intval($block->blurimage()->value())
      : (($backgroundType === 'video') ? intval($block->blurvideo()->value()) : 0);
$extraAttrs  = ' data-background-type="' . $backgroundType . '"';
$extraAttrs .= ' data-height="' . $block->height()->value() . '"';
if ($blur > 0) $extraAttrs .= ' data-blur style="--blur-amount:' . $blur . 'px"';

// Section
echo pwSnippet::sectionOpen('hero', $block, $settings, $extraAttrs);

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

// Grid open
echo pwSnippet::gridOpen($block);

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

// Close
echo pwSnippet::gridClose();
echo pwSnippet::sectionClose();
