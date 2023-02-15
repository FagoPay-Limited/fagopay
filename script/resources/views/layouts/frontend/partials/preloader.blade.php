 <style class="INLINE_PEN_STYLESHEET_ID">

body .vertical-centered-box {
  position: absolute;
  width: 100%;
  height: 100%;
  text-align: center;
}
body .vertical-centered-box:after {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -0.25em;
}
body .vertical-centered-box .content {
  box-sizing: border-box;
  display: inline-block;
  vertical-align: middle;
  text-align: left;
  font-size: 0;
}
* {
  transition: all 0.3s;
}

.loader-circle {
  position: absolute;
  left: 50%;
  top: 50%;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  box-shadow: inset 0 0 0 0px rgba(255, 255, 255, 0.1);
  margin-left: -50px;
  margin-top: -50px;
}
.breathe {
  -webkit-animation: breathing 1s ease-out infinite normal;
    animation: breathing 1s ease-out infinite normal;
}

.loader-line-mask {
  position: absolute;
  left: 50%;
  top: 50%;
  width: 40px;
  height: 100px;
  margin-left: -50px;
  margin-top: -50px;
  overflow: hidden;
  transform-origin: 50px 50px;
  -webkit-mask-image: -webkit-linear-gradient(top, #000000, rgba(0, 0, 0, 0));
  animation: rotate 1.2s infinite linear;
}

.loader-line-mask .loader-line {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  box-shadow: inset 0 0 0 10px  rgb(128 29 56 / 85%);
}
#particles-background,
#particles-foreground {
  left: -51%;
  top: -51%;
  width: 202%;
  height: 202%;
  transform: scale3d(0.5, 0.5, 1);
}
#particles-background {
  background: #2c2d44;
  background-image: -moz-linear-gradient(45deg, #3f3251 2%, #002025 100%);
  background-image: -webkit-linear-gradient(45deg, #3f3251 2%, #002025 100%);
  background-image: linear-gradient(45deg, #3f3251 2%, #002025 100%);
}
@keyframes rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes fade {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0.25;
  }
}
@keyframes fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}


@keyframes breathing {
  0% {
    -webkit-transform: scale(0.9);
    -ms-transform: scale(0.9);
    transform: scale(0.9);
  }

  50% {
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
  }

  100% {
    -webkit-transform: scale(0.9);
    -ms-transform: scale(0.9);
    transform: scale(0.9);
  }
}

#preloader {
    position: fixed;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background-color:#fff; /* change if the mask should have another color then white */
    z-index:99999; /* makes sure it stays on top */
}

  </style>
  
  <!-- Preloader -->
 <div id="preloader">
<div class="vertical-centered-box">
  <div class="content">
    <div class="loader-circle"></div>
    <div class="loader-line-mask">
      <div class="loader-line"></div>
    </div>
    <img class="breathe" height="75px" src="{{url('/')}}/uploads/1/22/07/path.png">
    
  </div>
</div>
</div> 
<!--Preloader-->

