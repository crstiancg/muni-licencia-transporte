<template>
  <button @click="toggleTheme" class="p-2 rounded">
    <!-- Icons (can use FontAwesome or inline SVGs) -->
    <i v-if="isDark" class="fa-regular fa-sun fa-lg"></i>
    <i v-else class="fa-regular fa-moon fa-lg"></i>
  </button>
</template>

<script>
export default {
  name: 'ThemeToggle',
  data() {
    return {
      isDark: false
    };
  },
  mounted() {
    // Check theme on component mount
    const userTheme = localStorage.getItem('color-theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    this.isDark = userTheme === 'dark' || (!userTheme && systemPrefersDark);

    if (this.isDark) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  },
  methods: {
    toggleTheme() {
      this.isDark = !this.isDark;

      if (this.isDark) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('color-theme', 'dark');
      } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('color-theme', 'light');
      }
    }
  }
};
</script>

<style scoped>
button {
  transition: background 0.3s ease;
}
</style>
