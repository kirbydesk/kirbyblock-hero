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
				...(content.backgroundtype === 'image' && backgroundImageUrl
					? { '--background-image': `url('${backgroundImageUrl}')` }
					: { '--background-image': 'none' }),
				'borderRadius': 'var(--rounded)',
				'aspectRatio': (content.backgroundtype === 'video' && content.video && content.video.length)
					? '16/9'
					: '21/9'
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
						<!-- Heading -->
						<pwHeading v-if="settings.heading" :value="content.heading" :data-level="content.level" />

						<!-- Textarea -->
						<pwTextarea v-if="settings.text" :value="content.texttextarea" />

						<!-- Buttons -->
						<pwButtons v-if="settings.buttons" :value="content.buttons" :align="content.buttonsalignment" />
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import pwBlockinfo from '@/../../kirby-pagewizard/src/components/blockinfo.vue';
import pwHeading from '@/../../kirby-pagewizard/src/components/heading.vue'
import pwTextarea from '@/../../kirby-pagewizard/src/components/textarea.vue'
import pwButtons from '@/../../kirby-pagewizard/src/components/buttons.vue'
import pwGridStyle from '@/../../kirby-pagewizard/src/mixins/gridStyle.js';
import pwColorStyle from '@/../../kirby-pagewizard/src/mixins/colorStyle.js';

export default {
	components: {
		pwBlockinfo,
		pwHeading,
		pwTextarea,
		pwButtons
	},
	mixins: [pwGridStyle, pwColorStyle],
	data() {
		return {
			settings: {}
		}
	},
	async created() {
		try {
			const response = await this.$api.get('pagewizard/settings/pwhero');
			this.settings = response.settings;
		} catch (e) {
			this.settings = {};
		}
	},
	computed: {
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
		background-position: center;
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
}
</style>
