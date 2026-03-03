<template>
	<div
		class="pwPreview"
		data-kirbyblock="hero"
		@dblclick="open"
		:style="colorVars"
		:data-margintop="content.margintop === true ? 'true' : null"
		:data-marginbottom="content.marginbottom === true ? 'true' : null"
		>

		<pwBlockinfo
			:value="$t('kirbyblock-hero.name')"
			icon="star"
		/>

		<div
			class="background"
			:style="{
				...(content.backgroundtype === 'image' && backgroundImageUrl && focusReady
					? { '--background-image': `url('${backgroundImageUrl}')`, '--background-position': imageFocus }
					: { '--background-image': 'none' }),
				'borderRadius': 'var(--rounded)',
				'aspectRatio': heightRatio
			}"
			>
			<video
				v-if="content.backgroundtype === 'video' && content.video && content.video.length"
				:src="content.video[0].url"
				muted
				playsinline
				class="background-video"
			></video>

			<div class="pwGrid">
				<div
					class="pwGridItem"
					:style="gridVars"
					:data-paddingtop="content.paddingtop === true ? 'true' : null"
					:data-paddingright="content.paddingright === true ? 'true' : null"
					:data-paddingbottom="content.paddingbottom === true ? 'true' : null"
					:data-paddingleft="content.paddingleft === true ? 'true' : null"
					>

					<div class="contents" :data-h="content.positionhorizontal" :data-v="content.positionvertical">

						<!-- Tagline -->
						<pwTagline v-if="settings.tagline" :value="content.tagline" :alignDefault="fieldDefaults['align-tagline']" />

						<!-- Heading -->
						<pwHeading v-if="settings.heading" :value="content.heading" :data-level="content.level" :alignDefault="fieldDefaults['align-heading']" />

						<!-- Editor -->
						<pwEditor v-if="settings.editor" :content="content" :alignDefault="fieldDefaults['align-editor']" />

						<!-- Buttons -->
						<pwButtons v-if="settings.buttons" :value="content.buttons" :align="content.buttonsalignment || fieldDefaults['align-buttons']" />

					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import pwBlockinfo from '@/../../kirby-pagewizard/src/components/blockinfo.vue';
import pwTagline from '@/../../kirby-pagewizard/src/components/tagline.vue'
import pwHeading from '@/../../kirby-pagewizard/src/components/heading.vue'
import pwEditor from '@/../../kirby-pagewizard/src/components/editor.vue'
import pwButtons from '@/../../kirby-pagewizard/src/components/buttons.vue'
import pwGridStyle from '@/../../kirby-pagewizard/src/mixins/gridStyle.js';
import pwColorStyle from '@/../../kirby-pagewizard/src/mixins/colorStyle.js';

export default {
	components: {
		pwBlockinfo,
		pwTagline,
		pwHeading,
		pwEditor,
		pwButtons
	},
	mixins: [pwGridStyle, pwColorStyle],
	data() {
		return {
			settings: {},
			fieldDefaults: {},
			imageFocus: '50% 50%',
			focusReady: false
		}
	},
	async created() {
		try {
			const response = await this.$api.get('pagewizard/settings/pwhero');
			this.settings = response.settings;
			this.fieldDefaults = response.fields || {};
		} catch (e) {
			this.settings = {};
		}
		this.loadFocus();
	},
	watch: {
		'content.image': {
			handler() { this.loadFocus(); },
			deep: true
		}
	},
	methods: {
		async loadFocus() {
			this.focusReady = false;
			if (!this.content.image || !this.content.image.length || !this.content.image[0]) {
				this.imageFocus = '50% 50%';
				this.focusReady = true;
				return;
			}
			const file = this.content.image[0];
			try {
				const data = await this.$api.get(file.parent + '/files/' + file.filename);
				this.imageFocus = data.content?.focus || '50% 50%';
			} catch (e) {
				this.imageFocus = '50% 50%';
			}
			this.focusReady = true;
		}
	},
	computed: {
		heightRatio() {
			const ratios = {
				auto: '5/1',
				small: '4/1',
				medium: '21/9',
				large: '16/9',
				fullscreen: '9/9'
			};
			return ratios[this.content.height] || '21/9';
		},
		backgroundImageUrl() {
			if (!this.content.image || !this.content.image.length || !this.content.image[0]) return '';
			const srcset = this.content.image[0].image?.srcset;
			if (!srcset) return this.content.image[0].url;
			const entries = srcset.split(',');
			const last = entries[entries.length - 1].trim().split(' ')[0];
			return last || this.content.image[0].url;
		}
	}
}
</script>

<style scoped>
div.pwPreview[data-kirbyblock="hero"] {
	padding: 0;

	div.background {
		position: relative;
		overflow: hidden;
	}
	div.background::before {
		content: "";
		position: absolute;
		inset: 0;
		z-index: 0;
		background-image: var(--background-image, none);
		background-size: cover;
		background-position: var(--background-position, center);
		background-repeat: no-repeat;
	}
	.background-video {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		object-fit: cover;
		z-index: 0;
	}
	.pwGrid {
		position: absolute;
		inset: 0;
		z-index: 1;

		.pwGridItem {
			background: transparent;
			display: flex;
			height: 100%;
		}
		.contents {
			display: flex;
			flex-direction: column;

			/* Horizontal */
			&[data-h="left"] { margin-right: auto; }
			&[data-h="center"] { margin-left: auto; margin-right: auto; }
			&[data-h="right"] { margin-left: auto; }

			/* Vertical */
			&[data-v="top"] { margin-bottom: auto; }
			&[data-v="middle"] { margin-top: auto; margin-bottom: auto; }
			&[data-v="bottom"] { margin-top: auto; }
		}
	}
	div.pwHeading {
		&[data-lvl="h1"]{
			font-size: var(--text-3xl);
			&[data-size="large"]{ font-size: var(--text-4xl); }
			&[data-size="xlarge"]{ font-size: var(--text-5xl); }
		}
		&[data-lvl="h2"]{
			font-size: var(--text-2xl);
			&[data-size="large"]{ font-size: var(--text-3xl); }
			&[data-size="xlarge"]{ font-size: var(--text-4xl); }
		}
		&[data-lvl="h3"]{
			font-size: var(--text-xl);
			&[data-size="large"]{ font-size: var(--text-2xl); }
			&[data-size="xlarge"]{ font-size: var(--text-3xl); }
		}
		&[data-lvl="h4"]{
			font-size: var(--text-md);
			&[data-size="large"]{ font-size: var(--text-xl); }
			&[data-size="xlarge"]{ font-size: var(--text-2xl); }
		}
	}
}
</style>
