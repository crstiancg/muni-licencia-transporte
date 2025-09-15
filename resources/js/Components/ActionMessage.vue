<script setup>
defineProps({
    on: Boolean,
});
</script>

<template>
  <transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="opacity-0 -translate-y-2"
    enter-to-class="opacity-100 translate-y-0"
    leave-active-class="transition ease-in duration-1000"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0 -translate-y-2"
  >
    <div
      v-show="on"
      class="fixed top-6 left-1/2 transform -translate-x-1/2 max-w-xs w-full bg-red-600 text-white px-4 py-3 rounded-lg shadow-lg font-semibold text-sm flex items-center space-x-2"
      style="display: none;"
    >
      <!-- Icono de error -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <div>
        <slot />
      </div>
    </div>
  </transition>
</template>
