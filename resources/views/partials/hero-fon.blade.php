{{-- Rasterised artwork (public/fon.svg) as a cached background texture;
    rendered once by the browser and composited cheaply while scrolling. --}}
<div class="hero-fon-bg" aria-hidden="true"></div>

{{-- Lightweight animated overlay: only the pulsing nodes, impulse rings and
    travelling sparks. The heavy gradient/blend artwork lives in the
    background image above, so scrolling the section stays cheap. --}}
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 360 144" class="hero-fon" preserveAspectRatio="xMidYMid slice" width="100%" height="100%" aria-hidden="true" focusable="false">
  <g class="hero-fon-nodes" aria-hidden="true">
    <circle class="hero-fon-node" cx="319.8" cy="26.7" r="5.5" fill="#7dd3fc"/>
    <circle class="hero-fon-node" cx="340.72" cy="136.78" r="5.5" fill="#7dd3fc"/>
    <circle class="hero-fon-node" cx="269.09" cy="68.08" r="5.5" fill="#60a5fa"/>
  </g>
  <g class="hero-fon-rings" aria-hidden="true">
    <g class="hero-fon-node-rings">
      <circle class="hero-fon-ring" cx="319.8" cy="26.7" r="22" style="--i:0"/>
      <circle class="hero-fon-ring hero-fon-ring--violet" cx="319.8" cy="26.7" r="22" style="--i:1"/>
    </g>
    <g class="hero-fon-node-rings">
      <circle class="hero-fon-ring" cx="340.72" cy="136.78" r="22" style="--i:0"/>
      <circle class="hero-fon-ring hero-fon-ring--violet" cx="340.72" cy="136.78" r="22" style="--i:1"/>
    </g>
    <g class="hero-fon-node-rings">
      <circle class="hero-fon-ring" cx="269.09" cy="68.08" r="22" style="--i:0"/>
      <circle class="hero-fon-ring hero-fon-ring--violet" cx="269.09" cy="68.08" r="22" style="--i:1"/>
    </g>
  </g>
  <g class="hero-fon-sparks" aria-hidden="true">
    <circle class="hero-fon-spark" r="3.2">
      <animateMotion dur="9s" repeatCount="indefinite" begin="0s"
        path="M369.14,172.42l-16.82-11.46,16.82-33.71v-.82l-17.12,34.32-110.39-75.24,73.29-63.62,54.22,11.7v-.37l-53.88-11.62,53.88-46.77v-.48l-54.33,47.16-73.22-15.79,6.83-48.4h-.37l-6.82,48.32-53.14-11.46-.08.36,53.17,11.47-10.25,72.56-.02.11,10.11,6.89-127.04,110.28-.18.16.48.31h.67l-.54-.35,126.93-110.18,110.52,75.33-17.56,35.21h.41l17.46-35,16.98,11.57v-.44ZM241.32,85.3l-10-6.81,10.22-72.42,72.93,15.73-73.16,63.5Z"/>
    </circle>
    <circle class="hero-fon-spark hero-fon-spark--violet" r="3.2">
      <animateMotion dur="9s" repeatCount="indefinite" begin="-2.25s"
        path="M369.14,161.41v-.37l-70.84,9.97-1.33-35.85,72.17-21.25v-.38l-72.18,21.25-5.69-153.06,77.88,5.24v-.37l-77.89-5.24-.89-24.05h-.37l.89,24.03-222.88-15-.36-.02,73.05,115.89-61.22,114.09h.41l61.03-113.73,52.32,83.01.07.12,103.3-30.42,1.33,35.8-179.21,25.23h2.62l176.6-24.86.92,24.86h.37l-.93-24.91,70.82-9.97ZM193.47,165.25l-52.35-83.06L188.21-5.57l-.32-.17-47,87.58L68.34-33.28l222.56,14.98,5.7,153.19-103.13,30.36Z"/>
    </circle>
    <circle class="hero-fon-spark" r="3.2">
      <animateMotion dur="9s" repeatCount="indefinite" begin="-4.5s"
        path="M254.64,81.41l114.51,85.39v-.46l-114.25-85.2L346.32-10.96l22.82,38.33v-.71l-22.56-37.88,13.55-13.66,9-7.15v-.47l-6.82,5.41,6.82-6.87v-.52l-9.25,9.32-14.67,11.65-17.38-29.19h-.43l17.52,29.42-104.92,83.33L105.27-30.43l16.33-12.26h-.61l-16.14,12.11-.2.15,135.06,100.72-8.42,6.69,4.88,22.51-96.1,96.81h.51l95.67-96.39,20.92,96.39h.37l-20.98-96.7,18.05-18.19ZM357.71-22.95l-11.32,11.4-.97-1.64,12.29-9.76ZM345.13-12.96l1,1.68-91.53,92.21-14.28-10.65L345.13-12.96ZM231.7,77.12l8.32-6.61,14.32,10.68-17.85,17.98-4.79-22.05Z"/>
    </circle>
    <circle class="hero-fon-spark hero-fon-spark--violet" r="3.2">
      <animateMotion dur="9s" repeatCount="indefinite" begin="-6.75s"
        path="M369.14,141.65l-.04.15-100.51-53.88-5.84-42.96,42.77-61.1,52.3,6.97,11.31,13.53v-.57l-10.78-12.89,10.78,1.44v-.37l-11.12-1.48-27.75-33.19h-.48l27.69,33.12-52.02-6.94h-.11s-42.67,60.95-42.67,60.95l-11.84-87.13h-.37l11.9,87.57-20.22,28.88-104.94-56.25,26.26-60.2h-.4l-26.27,60.21-.07.15,105.2,56.39-85.56,122.23h.45l85.44-122.06,25.99,13.93,8.8,64.76.36-.05-8.76-64.49,100.36,53.79-13.45,54.12h.38l13.2-53.12v-1.52ZM242.48,73.93l19.96-28.52,5.75,42.3-25.71-13.78Z"/>
    </circle>
  </g>
</svg>