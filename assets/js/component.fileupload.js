// ! function (n) {
//     "use strict";

//     function t() {
//         this.$body = n("body")
//     }
//     t.prototype.init = function () {       
//         Dropzone.autoDiscover = !1, n('[data-plugin="dropzone"]').each(function () {
//             var t = n(this).attr("action"),
//                 i = n(this).data("previewsContainer"),
//                 e = {
//                     url: t
//                 };
//             i && (e.previewsContainer = i);
//             var o = n(this).data("uploadPreviewTemplate");
//             o && (e.previewTemplate = n(o).html());
//             n(this).dropzone(e)
//         })
//     }, n.FileUpload = new t, n.FileUpload.Constructor = t
// }(window.jQuery),
// function () {
//     "use strict";
//     window.jQuery.FileUpload.init()
// }();

// Dropzone.options.myGreatDropzone  = {
//     url: "./functions/do_upload.php",
//     paramName: "imgvalues",
//     maxFilesize: 10,
//     maxFiles: 5,
//     acceptedFiles: "image/*,application/pdf",
//     autoProcessQueue: false,
//     init: function() {
//         this.on("addedfile", file => {
//           console.log("A file has been added");
//         });
//     },
//     accept: function(file, done) {
//         console.log(file.name)
//     },
// };

Dropzone.autoDiscover = false;

// $(function () {
//     //Dropzone class


// });