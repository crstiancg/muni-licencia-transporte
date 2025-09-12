<script setup>
import { computed } from "vue";

const props = defineProps({
  pagination: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["change"]);

const totalPages = computed(() =>
  Math.ceil(props.pagination.rowsNumber / props.pagination.rowsPerPage)
);

const goToPage = (page) => {
  if (page < 1 || page > totalPages.value) return;
  emit("change", page);
};
</script>

<template>
  <div class="flex justify-between items-center mt-4">
    <!-- Primero -->
    <button
      class="px-3 py-1 border rounded disabled:opacity-50"
      :disabled="pagination.page === 1"
      @click="goToPage(1)"
    >
      « Primero
    </button>

    <!-- Anterior -->
    <button
      class="px-3 py-1 border rounded disabled:opacity-50"
      :disabled="pagination.page === 1"
      @click="goToPage(pagination.page - 1)"
    >
      ‹ Anterior
    </button>

    <span>
      Página {{ pagination.page }} de {{ totalPages }}
    </span>

    <!-- Siguiente -->
    <button
      class="px-3 py-1 border rounded disabled:opacity-50"
      :disabled="pagination.page === totalPages"
      @click="goToPage(pagination.page + 1)"
    >
      Siguiente ›
    </button>

    <!-- Último -->
    <button
      class="px-3 py-1 border rounded disabled:opacity-50"
      :disabled="pagination.page === totalPages"
      @click="goToPage(totalPages)"
    >
      Último »
    </button>
  </div>
</template>