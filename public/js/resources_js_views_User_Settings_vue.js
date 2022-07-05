"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_User_Settings_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SubmitButton.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SubmitButton.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['pending', 'form', 'sendForm', 'text', 'isLoading', 'variant'],
  name: "SubmitButton"
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SuccessfulArticle.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SuccessfulArticle.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "SuccessfulArticle",
  props: ['showWhen', 'text']
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/MainSettingsBlock.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/MainSettingsBlock.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_SuccessfulArticle__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/components/SuccessfulArticle */ "./resources/js/components/SuccessfulArticle.vue");
/* harmony import */ var _components_SubmitButton__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/SubmitButton */ "./resources/js/components/SubmitButton.vue");
/* harmony import */ var _components_settings_SettingsRow__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/components/settings/SettingsRow */ "./resources/js/components/settings/SettingsRow.vue");
/* harmony import */ var _components_errors_ErrorMessage__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/components/errors/ErrorMessage */ "./resources/js/components/errors/ErrorMessage.vue");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _api_users__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/api/users */ "./resources/js/api/users.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm-bundler.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }








/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "MainSettingsBlock",
  components: {
    SuccessfulArticle: _components_SuccessfulArticle__WEBPACK_IMPORTED_MODULE_0__["default"],
    SubmitButton: _components_SubmitButton__WEBPACK_IMPORTED_MODULE_1__["default"],
    SettingsRow: _components_settings_SettingsRow__WEBPACK_IMPORTED_MODULE_2__["default"],
    ErrorMessage: _components_errors_ErrorMessage__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  data: function data() {
    return {
      form: {
        nickname: null
      },
      pending: false,
      errors: {},
      successed: false
    };
  },
  methods: {
    changeNickname: function changeNickname() {
      var _this = this;

      if (this.pending === false) {
        this.pending = true;
        this.successed = false;
        axios__WEBPACK_IMPORTED_MODULE_4___default().patch(_api_users__WEBPACK_IMPORTED_MODULE_5__.API_CHANGE_NICKNAME_URL, this.form).then(function (response) {
          _this.$store.commit('auth/setUser', response.data);

          _this.errors = {};
          _this.successed = true;
        })["catch"](function (errors) {
          var _errors$response$data;

          console.log(errors.response);
          _this.errors = ((_errors$response$data = errors.response.data) === null || _errors$response$data === void 0 ? void 0 : _errors$response$data.errors) || {
            'server': [errors.response.data.message]
          };
        }).then(function () {
          _this.pending = false;
        });
      }
    }
  },
  computed: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_6__.mapState)('auth', ['user'])), {}, {
    currentNickname: {
      get: function get() {
        return this.user.name;
      },
      set: function set(value) {
        this.form.nickname = value;
      }
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_SuccessfulArticle__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/components/SuccessfulArticle */ "./resources/js/components/SuccessfulArticle.vue");
/* harmony import */ var _components_SubmitButton__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/SubmitButton */ "./resources/js/components/SubmitButton.vue");
/* harmony import */ var _components_settings_SettingsRow__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/components/settings/SettingsRow */ "./resources/js/components/settings/SettingsRow.vue");
/* harmony import */ var _components_errors_ErrorMessage__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/components/errors/ErrorMessage */ "./resources/js/components/errors/ErrorMessage.vue");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _api_users__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/api/users */ "./resources/js/api/users.js");






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "PasswordSettingsBlock",
  components: {
    SuccessfulArticle: _components_SuccessfulArticle__WEBPACK_IMPORTED_MODULE_0__["default"],
    SubmitButton: _components_SubmitButton__WEBPACK_IMPORTED_MODULE_1__["default"],
    SettingsRow: _components_settings_SettingsRow__WEBPACK_IMPORTED_MODULE_2__["default"],
    ErrorMessage: _components_errors_ErrorMessage__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  data: function data() {
    return {
      form: {
        password: null,
        password_confirmation: null
      },
      pending: false,
      errors: {},
      successed: false
    };
  },
  methods: {
    changePassword: function changePassword() {
      var _this = this;

      if (this.pending === false) {
        this.pending = true;
        this.successed = false;
        axios__WEBPACK_IMPORTED_MODULE_4___default().patch(_api_users__WEBPACK_IMPORTED_MODULE_5__.API_CHANGE_PASSWORD_URL, this.form).then(function (response) {
          _this.errors = {};
          _this.successed = true;
        })["catch"](function (errors) {
          var _errors$response$data;

          console.log(errors.response);
          _this.errors = ((_errors$response$data = errors.response.data) === null || _errors$response$data === void 0 ? void 0 : _errors$response$data.errors) || {
            'server': [errors.response.data.message]
          };
        }).then(function () {
          _this.pending = false;
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/SettingsRow.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/SettingsRow.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "SettingsRow",
  props: ['propertyStyles', 'propertyName']
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/User/Settings.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/User/Settings.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_settings_MainSettingsBlock__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/components/settings/MainSettingsBlock */ "./resources/js/components/settings/MainSettingsBlock.vue");
/* harmony import */ var _components_settings_PasswordSettingsBlock__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/settings/PasswordSettingsBlock */ "./resources/js/components/settings/PasswordSettingsBlock.vue");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Settings",
  components: {
    PasswordSettingsBlock: _components_settings_PasswordSettingsBlock__WEBPACK_IMPORTED_MODULE_1__["default"],
    MainSettingsBlock: _components_settings_MainSettingsBlock__WEBPACK_IMPORTED_MODULE_0__["default"]
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SubmitButton.vue?vue&type=template&id=00f99055":
/*!**********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SubmitButton.vue?vue&type=template&id=00f99055 ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_o_button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("o-button");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_o_button, {
    variant: $props.variant || 'primary',
    onClick: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)($props.sendForm, ["prevent"]),
    disabled: $props.pending || Object.values($props.form).some(function (el) {
      return el === null;
    }),
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)($props.isLoading ? 'is-loading ' : '')
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.text), 1
      /* TEXT */
      )];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["variant", "onClick", "disabled", "class"]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SuccessfulArticle.vue?vue&type=template&id=4efd6821":
/*!***************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SuccessfulArticle.vue?vue&type=template&id=4efd6821 ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  key: 0,
  "class": "message is-primary"
};
var _hoisted_2 = {
  "class": "message-header"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Success ");

var _hoisted_4 = {
  "class": "message-body"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return $props.showWhen ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("article", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "delete",
    onClick: _cache[0] || (_cache[0] = function ($event) {
      return $props.showWhen = false;
    })
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.text), 1
  /* TEXT */
  )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/MainSettingsBlock.vue?vue&type=template&id=df0d9c20":
/*!************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/MainSettingsBlock.vue?vue&type=template&id=df0d9c20 ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "divider is-unselectable"
}, "User settings", -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _this = this;

  var _component_ErrorMessage = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ErrorMessage");

  var _component_SuccessfulArticle = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SuccessfulArticle");

  var _component_settings_row = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("settings-row");

  var _component_o_input = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("o-input");

  var _component_submit_button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("submit-button");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [_hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ErrorMessage, {
    errors: $data.errors
  }, null, 8
  /* PROPS */
  , ["errors"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_SuccessfulArticle, {
    "show-when": $data.successed,
    text: 'Successfully change name'
  }, null, 8
  /* PROPS */
  , ["show-when"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_settings_row, {
    "property-name": 'Email (hold to show)',
    "property-styles": 'is-spoiler'
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_this.user.email), 1
      /* TEXT */
      )];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["property-name"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_settings_row, {
    "property-name": 'Nickname'
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_o_input, {
        type: "text",
        modelValue: $options.currentNickname,
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          return $options.currentNickname = $event;
        })
      }, null, 8
      /* PROPS */
      , ["modelValue"])];
    }),
    _: 1
    /* STABLE */

  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_submit_button, {
    pending: $data.pending,
    form: $data.form,
    text: 'Change username',
    "class": "is-fullwidth",
    "is-loading": $data.pending,
    variant: 'basic',
    "send-form": $options.changeNickname
  }, null, 8
  /* PROPS */
  , ["pending", "form", "is-loading", "send-form"])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=template&id=45865c64":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=template&id=45865c64 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "divider is-unselectable"
}, "User password", -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ErrorMessage = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ErrorMessage");

  var _component_SuccessfulArticle = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SuccessfulArticle");

  var _component_o_input = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("o-input");

  var _component_settings_row = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("settings-row");

  var _component_submit_button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("submit-button");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [_hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ErrorMessage, {
    errors: $data.errors
  }, null, 8
  /* PROPS */
  , ["errors"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_SuccessfulArticle, {
    "show-when": $data.successed,
    text: 'Successfully change password'
  }, null, 8
  /* PROPS */
  , ["show-when"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_settings_row, {
    "property-name": 'New password'
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_o_input, {
        type: "password",
        modelValue: $data.form.password,
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          return $data.form.password = $event;
        })
      }, null, 8
      /* PROPS */
      , ["modelValue"])];
    }),
    _: 1
    /* STABLE */

  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_settings_row, {
    "property-name": 'Confirm new password'
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_o_input, {
        type: "password",
        modelValue: $data.form.password_confirmation,
        "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
          return $data.form.password_confirmation = $event;
        })
      }, null, 8
      /* PROPS */
      , ["modelValue"])];
    }),
    _: 1
    /* STABLE */

  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_submit_button, {
    pending: $data.pending,
    form: $data.form,
    text: 'Change password',
    "class": "is-fullwidth",
    "is-loading": $data.pending,
    variant: 'basic',
    "send-form": $options.changePassword
  }, null, 8
  /* PROPS */
  , ["pending", "form", "is-loading", "send-form"])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/SettingsRow.vue?vue&type=template&id=19d391f6":
/*!******************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/SettingsRow.vue?vue&type=template&id=19d391f6 ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "columns"
};
var _hoisted_2 = {
  "class": "column is-justify-content-end is-flex has-text-right is-align-items-center"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.propertyName), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["column", $props.propertyStyles])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.renderSlot)(_ctx.$slots, "default")], 2
  /* CLASS */
  )]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/User/Settings.vue?vue&type=template&id=d900e810":
/*!******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/User/Settings.vue?vue&type=template&id=d900e810 ***!
  \******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_main_settings_block = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("main-settings-block");

  var _component_password_settings_block = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("password-settings-block");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_main_settings_block), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_password_settings_block)], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./resources/js/components/SubmitButton.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/SubmitButton.vue ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SubmitButton_vue_vue_type_template_id_00f99055__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SubmitButton.vue?vue&type=template&id=00f99055 */ "./resources/js/components/SubmitButton.vue?vue&type=template&id=00f99055");
/* harmony import */ var _SubmitButton_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SubmitButton.vue?vue&type=script&lang=js */ "./resources/js/components/SubmitButton.vue?vue&type=script&lang=js");
/* harmony import */ var D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_SubmitButton_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_SubmitButton_vue_vue_type_template_id_00f99055__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/SubmitButton.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/SuccessfulArticle.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/SuccessfulArticle.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SuccessfulArticle_vue_vue_type_template_id_4efd6821__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SuccessfulArticle.vue?vue&type=template&id=4efd6821 */ "./resources/js/components/SuccessfulArticle.vue?vue&type=template&id=4efd6821");
/* harmony import */ var _SuccessfulArticle_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SuccessfulArticle.vue?vue&type=script&lang=js */ "./resources/js/components/SuccessfulArticle.vue?vue&type=script&lang=js");
/* harmony import */ var D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_SuccessfulArticle_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_SuccessfulArticle_vue_vue_type_template_id_4efd6821__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/SuccessfulArticle.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/MainSettingsBlock.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/settings/MainSettingsBlock.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _MainSettingsBlock_vue_vue_type_template_id_df0d9c20__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MainSettingsBlock.vue?vue&type=template&id=df0d9c20 */ "./resources/js/components/settings/MainSettingsBlock.vue?vue&type=template&id=df0d9c20");
/* harmony import */ var _MainSettingsBlock_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MainSettingsBlock.vue?vue&type=script&lang=js */ "./resources/js/components/settings/MainSettingsBlock.vue?vue&type=script&lang=js");
/* harmony import */ var D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_MainSettingsBlock_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_MainSettingsBlock_vue_vue_type_template_id_df0d9c20__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/MainSettingsBlock.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/PasswordSettingsBlock.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/settings/PasswordSettingsBlock.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PasswordSettingsBlock_vue_vue_type_template_id_45865c64__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PasswordSettingsBlock.vue?vue&type=template&id=45865c64 */ "./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=template&id=45865c64");
/* harmony import */ var _PasswordSettingsBlock_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PasswordSettingsBlock.vue?vue&type=script&lang=js */ "./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=script&lang=js");
/* harmony import */ var D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_PasswordSettingsBlock_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_PasswordSettingsBlock_vue_vue_type_template_id_45865c64__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/PasswordSettingsBlock.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/settings/SettingsRow.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/settings/SettingsRow.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SettingsRow_vue_vue_type_template_id_19d391f6__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SettingsRow.vue?vue&type=template&id=19d391f6 */ "./resources/js/components/settings/SettingsRow.vue?vue&type=template&id=19d391f6");
/* harmony import */ var _SettingsRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SettingsRow.vue?vue&type=script&lang=js */ "./resources/js/components/settings/SettingsRow.vue?vue&type=script&lang=js");
/* harmony import */ var D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_SettingsRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_SettingsRow_vue_vue_type_template_id_19d391f6__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/settings/SettingsRow.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/User/Settings.vue":
/*!**********************************************!*\
  !*** ./resources/js/views/User/Settings.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Settings_vue_vue_type_template_id_d900e810__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Settings.vue?vue&type=template&id=d900e810 */ "./resources/js/views/User/Settings.vue?vue&type=template&id=d900e810");
/* harmony import */ var _Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Settings.vue?vue&type=script&lang=js */ "./resources/js/views/User/Settings.vue?vue&type=script&lang=js");
/* harmony import */ var D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,D_Download_OpenServer_OpenServerNew54_domains_joint_viewing_app_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Settings_vue_vue_type_template_id_d900e810__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/User/Settings.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/SubmitButton.vue?vue&type=script&lang=js":
/*!**************************************************************************!*\
  !*** ./resources/js/components/SubmitButton.vue?vue&type=script&lang=js ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SubmitButton_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SubmitButton_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SubmitButton.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SubmitButton.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/SuccessfulArticle.vue?vue&type=script&lang=js":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/SuccessfulArticle.vue?vue&type=script&lang=js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SuccessfulArticle_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SuccessfulArticle_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SuccessfulArticle.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SuccessfulArticle.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/MainSettingsBlock.vue?vue&type=script&lang=js":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/settings/MainSettingsBlock.vue?vue&type=script&lang=js ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MainSettingsBlock_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MainSettingsBlock_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MainSettingsBlock.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/MainSettingsBlock.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=script&lang=js":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=script&lang=js ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PasswordSettingsBlock_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PasswordSettingsBlock_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PasswordSettingsBlock.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/settings/SettingsRow.vue?vue&type=script&lang=js":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/settings/SettingsRow.vue?vue&type=script&lang=js ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SettingsRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SettingsRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SettingsRow.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/SettingsRow.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/User/Settings.vue?vue&type=script&lang=js":
/*!**********************************************************************!*\
  !*** ./resources/js/views/User/Settings.vue?vue&type=script&lang=js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Settings.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/User/Settings.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/SubmitButton.vue?vue&type=template&id=00f99055":
/*!********************************************************************************!*\
  !*** ./resources/js/components/SubmitButton.vue?vue&type=template&id=00f99055 ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SubmitButton_vue_vue_type_template_id_00f99055__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SubmitButton_vue_vue_type_template_id_00f99055__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SubmitButton.vue?vue&type=template&id=00f99055 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SubmitButton.vue?vue&type=template&id=00f99055");


/***/ }),

/***/ "./resources/js/components/SuccessfulArticle.vue?vue&type=template&id=4efd6821":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/SuccessfulArticle.vue?vue&type=template&id=4efd6821 ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SuccessfulArticle_vue_vue_type_template_id_4efd6821__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SuccessfulArticle_vue_vue_type_template_id_4efd6821__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SuccessfulArticle.vue?vue&type=template&id=4efd6821 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/SuccessfulArticle.vue?vue&type=template&id=4efd6821");


/***/ }),

/***/ "./resources/js/components/settings/MainSettingsBlock.vue?vue&type=template&id=df0d9c20":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/settings/MainSettingsBlock.vue?vue&type=template&id=df0d9c20 ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MainSettingsBlock_vue_vue_type_template_id_df0d9c20__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MainSettingsBlock_vue_vue_type_template_id_df0d9c20__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MainSettingsBlock.vue?vue&type=template&id=df0d9c20 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/MainSettingsBlock.vue?vue&type=template&id=df0d9c20");


/***/ }),

/***/ "./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=template&id=45865c64":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=template&id=45865c64 ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PasswordSettingsBlock_vue_vue_type_template_id_45865c64__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PasswordSettingsBlock_vue_vue_type_template_id_45865c64__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PasswordSettingsBlock.vue?vue&type=template&id=45865c64 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/PasswordSettingsBlock.vue?vue&type=template&id=45865c64");


/***/ }),

/***/ "./resources/js/components/settings/SettingsRow.vue?vue&type=template&id=19d391f6":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/settings/SettingsRow.vue?vue&type=template&id=19d391f6 ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SettingsRow_vue_vue_type_template_id_19d391f6__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SettingsRow_vue_vue_type_template_id_19d391f6__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SettingsRow.vue?vue&type=template&id=19d391f6 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/settings/SettingsRow.vue?vue&type=template&id=19d391f6");


/***/ }),

/***/ "./resources/js/views/User/Settings.vue?vue&type=template&id=d900e810":
/*!****************************************************************************!*\
  !*** ./resources/js/views/User/Settings.vue?vue&type=template&id=d900e810 ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_template_id_d900e810__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_template_id_d900e810__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Settings.vue?vue&type=template&id=d900e810 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/User/Settings.vue?vue&type=template&id=d900e810");


/***/ })

}]);