<script setup>

</script>
<template>
  <div class="min-h-screen flex flex-col sm:justify-normal items-center pt-6 sm:pt-0 bg-gray-900 dark:bg-gray-900">
    <div
      class="max-w-[1600px] w-full rounded-full h-[396px] bg-gradient-to-b from-transparent from-0% via-90% to-100% via-gray-700 to-transparent absolute bg-opacity-50 left-1/2 -translate-x-1/2 top-[200px] blur-[100px]">
    </div>
    <div class="w-full sm:max-w-xl  px-6 lg:py-4 py-40 overflow-hidden sm:rounded-lg">
      <slot />
    </div>
  </div>
</template>