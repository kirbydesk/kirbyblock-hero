(function() {
  "use strict";
  function normalizeComponent(scriptExports, render, staticRenderFns, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render) {
      options.render = render;
      options.staticRenderFns = staticRenderFns;
      options._compiled = true;
    }
    if (scopeId) {
      options._scopeId = "data-v-" + scopeId;
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const _sfc_main$1 = {
    props: {
      value: String,
      icon: String,
      layout: String
    }
  };
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "blockinfo" }, [_c("div", [_c("svg", { staticClass: "k-icon", attrs: { "aria-hidden": "true" } }, [_c("use", { attrs: { "xlink:href": "#icon-" + _vm.icon } })]), _vm._v(" " + _vm._s(_vm.value) + " "), _vm.layout ? _c("span", [_vm._v("(" + _vm._s(_vm.layout) + ")")]) : _vm._e()])]);
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1,
    false,
    null,
    "26526d24"
  );
  __component__$1.options.__file = "/Users/christian/Projects/kirbydesk/site/plugins/kirby-pagewizard/src/components/blockinfo.vue";
  const pwBlockinfo = __component__$1.exports;
  const pwGridStyle = {
    computed: {
      gridVars() {
        return {
          "--grid-start-sm": Number(this.content.gridoffsetsm),
          "--grid-span-sm": Number(this.content.gridsizesm),
          "--grid-start-md": Number(this.content.gridoffsetmd),
          "--grid-span-md": Number(this.content.gridsizemd),
          "--grid-start-lg": Number(this.content.gridoffsetlg),
          "--grid-span-lg": Number(this.content.gridsizelg),
          "--grid-start-xl": Number(this.content.gridoffsetxl),
          "--grid-span-xl": Number(this.content.gridsizexl)
        };
      }
    }
  };
  const _sfc_main = {
    components: {
      pwBlockinfo
    },
    mixins: [pwGridStyle]
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "pwPreview", attrs: { "data-kirbyblock": "hero", "data-margintop": _vm.content.margintop === true ? "true" : null, "data-marginbottom": _vm.content.marginbottom === true ? "true" : null }, on: { "dblclick": _vm.open } }, [_c("pwBlockinfo", { attrs: { "value": _vm.$t("kirbyblock-hero.name"), "icon": "star" } }), _c("div", { staticClass: "pwGrid" }, [_c("div", { staticClass: "pwGridItem", style: _vm.gridVars, attrs: { "data-paddingtop": _vm.content.paddingtop === true ? "true" : null, "data-paddingbottom": _vm.content.paddingbottom === true ? "true" : null } })])], 1);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns,
    false,
    null,
    null
  );
  __component__.options.__file = "/Users/christian/Projects/kirbydesk/site/plugins/kirbyblock-hero/src/blocks/index.vue";
  const pwhero = __component__.exports;
  panel.plugin("kirbydesk/kirbyblock-hero", {
    blocks: {
      pwhero
    }
  });
})();
