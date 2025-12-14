<div class="fire-bottom">
  <div class="fire-container">
    <div class="flame">
      <div class="flame-inner"></div>
    </div>
    <div class="embers" id="embers"></div>
  </div>
</div>

<style>
  .fire-bottom {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    align-items: flex-end;
    width: 100%;
    pointer-events: none;
    /* tidak ganggu klik form */
    z-index: 0;
  }

  .fire-container {
    position: relative;
    width: 100px;
    /* width: 100%; */
    height: 220px;
    display: flex;
    justify-content: center;
    align-items: flex-end;
  }

  .flame {
    position: absolute;
    bottom: 0;
    width: 100px;
    height: 100px;
    background: linear-gradient(to top, #ff4500, #ff7800);
    border-radius: 45% 45% 40% 40% / 40% 40% 60% 60%;
    transform-origin: center bottom;
    box-shadow: 0 0 80px 15px rgba(255, 69, 0, 0.5);
    animation: flicker 3s ease-in-out infinite;
    filter: blur(1px);
    opacity: 0.9;
  }

  .flame::before,
  .flame::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: inherit;
    background: inherit;
  }

  .flame::before {
    transform: scale(0.9) translate(10%, 10%);
    filter: blur(12px);
    animation: pulse 4s infinite alternate;
  }

  .flame::after {
    transform: scale(0.8) translate(-10%, 10%);
    filter: blur(15px);
    animation: pulse 6s infinite alternate-reverse;
  }

  .flame-inner {
    position: absolute;
    bottom: 10%;
    left: 25%;
    width: 50%;
    height: 60%;
    background: #ffdd1f;
    border-radius: 50% 50% 35% 35% / 50% 50% 65% 65%;
    animation: pulse 2s ease-in-out infinite alternate;
    filter: blur(2px);
    opacity: 0.8;
  }

  .embers {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 120px;
    pointer-events: none;
  }

  .ember {
    position: absolute;
    bottom: 0;
    width: 6px;
    height: 6px;
    background: #ff7800;
    border-radius: 50%;
    animation: ember-rise 3s linear infinite;
    opacity: 0;
  }

  @keyframes flicker {

    0%,
    100% {
      transform: scale(1);
      opacity: 0.9;
    }

    50% {
      transform: scale(1.05) translateY(-2px);
      opacity: 1;
    }
  }

  @keyframes pulse {
    from {
      transform: scale(0.8);
    }

    to {
      transform: scale(1.1) translateY(-5px);
    }
  }

  @keyframes ember-rise {
    0% {
      bottom: 0;
      opacity: 0;
    }

    10% {
      opacity: 1;
    }

    100% {
      bottom: 100%;
      opacity: 0;
      transform: translateX(calc(var(--rand-x) * 30px));
    }
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const embers = document.getElementById("embers");

    function createEmber() {
        const ember = document.createElement("div");
        ember.className = "ember";

        ember.style.left = `${20 + Math.random() * 60}%`;
        ember.style.animationDuration = `${2 + Math.random() * 3}s`;
        ember.style.setProperty("--rand-x", Math.random() * 2 - 1);

        embers.appendChild(ember);

        setTimeout(() => {
            ember.remove();
            createEmber();
        }, 4000);
    }

    for (let i = 0; i < 15; i++) createEmber();
});
</script>