<div class="animasi_logo">
  <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
</div>

<style>
  .animasi_logo {
    display: flex;
    justify-content: center;
    align-items: center;
    animation: zoomPulse 10s ease-in-out infinite;
    padding: 20px 0;
  }

  @keyframes zoomPulse {
    0% {
      transform: scale(1);
      opacity: 0.9;
    }

    50% {
      transform: scale(1.3);
      opacity: 1;
    }

    100% {
      transform: scale(1);
      opacity: 0.9;
    }
  }
</style>