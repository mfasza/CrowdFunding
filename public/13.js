(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Verification.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Verification.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'emailVerification',
  data: function data() {
    return {
      valid: true,
      otp: "",
      otpRules: [function (v) {
        return !!v || 'OTP Code required.';
      }, function (v) {
        return /^\d+$/.test(v) || 'OTP Code must be a number.';
      }, function (v) {
        return /^.{6,}$/.test(v) || 'Minimum 6 digit OTP Code';
      }],
      email: "",
      emailRules: [function (v) {
        return !!v || 'E-mail is required.';
      }, function (v) {
        return /.+@.+\..+/.test(v) || 'Email must be valid';
      }],
      regenerate: false
    };
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])({
    setAlert: 'alert/showAlert',
    setDialogComponent: 'dialog/setComponent',
    setAuth: 'auth/set'
  })), {}, {
    verif: function verif() {
      var _this = this;

      if (this.$refs.form.validate()) {
        var formData = {
          otp_code: this.otp
        };
        axios.post("/api/auth/verification", formData).then(function (response) {
          var _response$data = response.data,
              response_code = _response$data.response_code,
              response_message = _response$data.response_message,
              response_data = _response$data.response_data;

          _this.setAuth(response_data);

          _this.$refs.form.reset();

          _this.$refs.form.resetValidation();

          if (response_code == '01') {
            _this.setAlert({
              color: 'error',
              text: response_message,
              outline: true
            });
          } else {
            _this.setAlert({
              color: 'success',
              text: response_message,
              outline: false
            });

            _this.$router.push({
              name: 'home'
            });

            _this.setDialogComponent('UpdatePassword');
          }
        })["catch"](function (error) {
          console.log(error);
        });
      }
    },
    generateOtp: function generateOtp() {
      var _this2 = this;

      if (this.$refs.formRegenerate.validate()) {
        var formData = {
          email: this.email
        };
        axios.post("/api/auth/regenerate-otp", formData).then(function (response) {
          var _response$data2 = response.data,
              response_code = _response$data2.response_code,
              response_message = _response$data2.response_message;

          _this2.$refs.formRegenerate.reset();

          _this2.$refs.formRegenerate.resetValidation();

          if (response_code == '01') {
            _this2.setAlert({
              color: 'error',
              text: response_message,
              outline: true
            });
          } else {
            _this2.setAlert({
              color: 'success',
              text: response_message,
              outline: false
            });
          }
        })["catch"](function (error) {
          console.log(error);
        });
      }
    }
  })
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Verification.vue?vue&type=template&id=31c5393a&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Verification.vue?vue&type=template&id=31c5393a& ***!
  \**********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-container",
    { attrs: { fluid: "" } },
    [
      _c(
        "v-form",
        {
          ref: "form",
          attrs: { "lazy-validation": "" },
          model: {
            value: _vm.valid,
            callback: function($$v) {
              _vm.valid = $$v
            },
            expression: "valid"
          }
        },
        [
          _c("v-text-field", {
            attrs: {
              rules: _vm.otpRules,
              label: "Kode OTP",
              maxlength: "6",
              counter: "",
              required: "",
              "append-icon": "mdi-key"
            },
            on: {
              keypress: function($event) {
                if (
                  !$event.type.indexOf("key") &&
                  _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                ) {
                  return null
                }
                $event.preventDefault()
              }
            },
            model: {
              value: _vm.otp,
              callback: function($$v) {
                _vm.otp = $$v
              },
              expression: "otp"
            }
          }),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "text-xs-center d-flex justify-space-between align-center"
            },
            [
              _c(
                "v-btn",
                {
                  attrs: { color: "success lighten-1", disabled: !_vm.valid },
                  on: { click: _vm.verif }
                },
                [
                  _vm._v(" Verifikasi "),
                  _c("v-icon", { attrs: { dark: "", right: "", medium: "" } }, [
                    _vm._v("mdi-send")
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "text-decoration-none",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.regenerate = !_vm.regenerate
                    }
                  }
                },
                [_vm._v("Regenerate OTP Code")]
              )
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-form",
        {
          ref: "formRegenerate",
          attrs: { "lazy-validation": "" },
          model: {
            value: _vm.valid,
            callback: function($$v) {
              _vm.valid = $$v
            },
            expression: "valid"
          }
        },
        [
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.regenerate,
                  expression: "regenerate"
                }
              ]
            },
            [
              _c("v-divider"),
              _vm._v(" "),
              _c("v-text-field", {
                attrs: {
                  rules: _vm.emailRules,
                  label: "E-mail",
                  required: "",
                  "append-icon": "mdi-email"
                },
                model: {
                  value: _vm.email,
                  callback: function($$v) {
                    _vm.email = $$v
                  },
                  expression: "email"
                }
              }),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "text-xs-center d-flex justify-space-between align-center"
                },
                [
                  _c(
                    "v-btn",
                    {
                      attrs: {
                        color: "primary lighten-1",
                        disabled: !_vm.valid
                      },
                      on: { click: _vm.generateOtp }
                    },
                    [_vm._v(" send OTP Code ")]
                  )
                ],
                1
              )
            ],
            1
          )
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/Verification.vue":
/*!*********************************************!*\
  !*** ./resources/js/views/Verification.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Verification_vue_vue_type_template_id_31c5393a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Verification.vue?vue&type=template&id=31c5393a& */ "./resources/js/views/Verification.vue?vue&type=template&id=31c5393a&");
/* harmony import */ var _Verification_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Verification.vue?vue&type=script&lang=js& */ "./resources/js/views/Verification.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Verification_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Verification_vue_vue_type_template_id_31c5393a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Verification_vue_vue_type_template_id_31c5393a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/Verification.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/Verification.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/views/Verification.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Verification_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Verification.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Verification.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Verification_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/Verification.vue?vue&type=template&id=31c5393a&":
/*!****************************************************************************!*\
  !*** ./resources/js/views/Verification.vue?vue&type=template&id=31c5393a& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Verification_vue_vue_type_template_id_31c5393a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Verification.vue?vue&type=template&id=31c5393a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Verification.vue?vue&type=template&id=31c5393a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Verification_vue_vue_type_template_id_31c5393a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Verification_vue_vue_type_template_id_31c5393a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);