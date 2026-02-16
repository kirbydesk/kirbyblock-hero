<template>
	<div
		class="pwPreview"
		data-kirbyblock="hero"
		@dblclick="open"
		:data-margintop="content.margintop === true ? 'true' : null"
		:data-marginbottom="content.marginbottom === true ? 'true' : null"
		>

		<pwBlockinfo
			:value="$t('kirbyblock-hero.name')"
			icon="star"
		/>

		<div class="pwGrid">
			<div
				class="pwGridItem"
				:style="gridVars"
				:data-paddingtop="content.paddingtop === true ? 'true' : null"
				:data-paddingbottom="content.paddingbottom === true ? 'true' : null"
				>


			</div>
		</div>
	</div>
</template>

<script>
import pwBlockinfo from '@/../../kirby-pagewizard/src/components/blockinfo.vue';

import pwGridStyle from '@/../../kirby-pagewizard/src/mixins/gridStyle.js';

export default {
	components: {
		pwBlockinfo
	},
	mixins: [pwGridStyle]
}
</script>