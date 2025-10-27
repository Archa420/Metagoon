<template>
  <div
    @click="goToVacancy"
    class="relative cursor-pointer group p-6 rounded-2xl border border-indigo-900/30 
           bg-gradient-to-br from-[#0f1116] via-[#141820] to-[#0f1116]
           shadow-[0_0_15px_rgba(0,0,0,0.5)] hover:shadow-[0_0_25px_rgba(99,102,241,0.2)]
           hover:border-indigo-500/40 hover:-translate-y-1 transition-all duration-300 overflow-hidden"
  >
    <!-- Subtle Glow Background -->
    <div
      class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500
             bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))]
             from-indigo-600/20 via-fuchsia-600/10 to-transparent pointer-events-none"
    ></div>

    <!-- Favorite Toggle Button -->
    <button
      @click.stop="toggleFavorite"
      class="absolute top-3 right-3 text-xl transition-all duration-300 z-20 active:scale-90"
      :class="isFavorited ? 'text-pink-500 scale-110' : 'text-gray-500 hover:text-pink-400'"
      title="Pievienot favorītiem"
    >
      <i :class="isFavorited ? 'fas fa-heart' : 'far fa-heart'"></i>
    </button>

    <div class="relative flex items-start gap-5 z-10">
      <!-- Logo -->
      <img
        :src="logo ? `http://127.0.0.1:8000/storage/${logo}` : '/default-logo.png'"
        alt="company logo"
        class="w-20 h-20 rounded-xl object-cover border border-gray-800 group-hover:border-indigo-500 transition-all duration-300"
      />

      <!-- Details -->
      <div class="flex flex-col flex-1 space-y-2">
        <!-- Title -->
        <h2
          class="text-2xl font-semibold text-gray-100 group-hover:text-indigo-400 transition-colors duration-300"
        >
          {{ title }}
        </h2>

        <!-- Company -->
        <p class="text-sm text-gray-400">{{ company }}</p>

        <!-- Category & Location -->
        <div class="flex flex-wrap items-center gap-2 mt-1">
          <span
            class="flex items-center text-xs font-medium text-indigo-400 bg-indigo-500/10 
                   px-2.5 py-1 rounded-full border border-indigo-500/20"
          >
            {{ category }}
          </span>
          <span
            class="flex items-center text-xs font-medium text-cyan-400 bg-cyan-500/10 
                   px-2.5 py-1 rounded-full border border-cyan-500/20"
          >
            {{ county }}
          </span>
        </div>

        <!-- Description -->
        <p class="mt-2 text-sm text-gray-300 line-clamp-2">
          {{ description }}
        </p>

        <!-- Salary -->
        <p class="mt-3 font-semibold text-indigo-400">
          Alga: {{ salary }} €
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { useRouter } from "vue-router";
import api from "@/services/api";

const props = defineProps({
  id: Number,
  logo: String,
  title: String,
  company: String,
  salary: String,
  description: String,
  category: String,
  county: String,
  isFavorite: { type: Boolean, default: false },
});

const emit = defineEmits(["favoriteChanged"]);
const router = useRouter();
const token = localStorage.getItem("token");
const isFavorited = ref(props.isFavorite);

const toggleFavorite = async () => {
  if (!token) {
    alert("Lūdzu pieslēdzieties, lai pievienotu favorītiem.");
    return;
  }

  try {
    const res = await api.post(`/favorites/${props.id}`, {}, {
      headers: { Authorization: `Bearer ${token}` },
    });
    isFavorited.value = res.data.favorited;
    emit("favoriteChanged", { id: props.id, favorited: isFavorited.value });
  } catch (err) {
    console.error(err);
    alert("Neizdevās mainīt favorītu statusu.");
  }
};

onMounted(() => {
  isFavorited.value = props.isFavorite;
});

watch(
  () => props.isFavorite,
  (newVal) => {
    isFavorited.value = newVal;
  }
);

const goToVacancy = () => router.push(`/vacancy/${props.id}`);
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  line-clamp: 2; /* Standard property */
}
</style>
