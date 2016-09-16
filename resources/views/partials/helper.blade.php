<style>
@font-face {
  font-family: 'iconfont';
  src: url('//at.alicdn.com/t/font_1473999066_8569658.eot'); /* IE9*/
  src: url('//at.alicdn.com/t/font_1473999066_8569658.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
  url('//at.alicdn.com/t/font_1473999066_8569658.woff') format('woff'), /* chrome、firefox */
  url('//at.alicdn.com/t/font_1473999066_8569658.ttf') format('truetype'), /* chrome、firefox、opera、Safari, Android, iOS 4.2+*/
  url('//at.alicdn.com/t/font_1473999066_8569658.svg#iconfont') format('svg'); /* iOS 4.1- */
}
.iconfont {
  font-family:"iconfont" !important;
  font-size:16px;
  font-style:normal;
  -webkit-font-smoothing: antialiased;
  -webkit-text-stroke-width: 0.2px;
  -moz-osx-font-smoothing: grayscale;
}
.icon-qq:before { content: "\e600"; }

#slide_helper {
  position: fixed;
  z-index: 999;
  bottom: 40px;
  right: 40px;
  width: 45px;
  height: 90px;
  border: 1px solid #eee;
  background: rgba(250, 107, 107, .9);
  box-sizing: content-box;
  -webkit-transform: translateZ(0);
}

#slide_helper > div {
  width: 45px;
  height: 45px;
  line-height: 45px;
  text-align: center;
  color: #f9f9f9;
  border-bottom: 1px solid #eee;
  cursor: pointer;
}

#slide_helper i {
  color: #f9f9f9;
}

#slide_helper > div:hover {
  background: rgb(255, 107, 105);
}
</style>
<div id="slide_helper">
  <div class="translator" @click="switchLanguage">@{{language}}</div>
  <div class="socialite"><a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=430d0963b334cc98c5724f8cd3a18a4e64d1c45c81aa29c3ec85d0c242c67455"><i class="iconfont icon-qq"></i></a></div>
</div>