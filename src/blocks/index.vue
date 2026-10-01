<template>
	<!-- the block in the panel: its info bar and the shared preview of the
	     Project Wizard (the project's look, the real background and content);
	     a double click opens the block -->
	<div class="pwPreview" data-kirbyblock="hero" @dblclick="open">

		<pwBlockinfo
			:value="$t('kirbyblock-hero.name')"
			:design="'pwhero'"
			icon="star"
		/>

		<pw-block-panel-preview type="pwhero" :content="content" />

	</div>
</template>

<script>
import pwBlockinfo from '@/../../kirby-pagewizard/src/components/blockinfo.vue';

export default {
	components: {
		pwBlockinfo
	}
}
</script>
