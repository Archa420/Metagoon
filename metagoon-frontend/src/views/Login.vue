<template>
  <div class="min-h-screen flex items-center justify-center bg-[#0b0c10] text-gray-100 px-6">
    <div
      class="w-full max-w-md rounded-3xl border border-indigo-900/30 bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 p-8 shadow-2xl relative overflow-hidden"
    >
      <!-- Glow overlay -->
      <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-indigo-700/20 via-fuchsia-700/10 to-transparent pointer-events-none"></div>

      <!-- Heading -->
      <div class="relative text-center space-y-2 z-10">
        <h1
          class="text-4xl font-extrabold bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent"
        >
          Pieslēgties
        </h1>
        <p class="text-gray-400 text-sm">
          Laipni lūgts atpakaļ MetaGoon! Ievadi savus datus, lai turpinātu.
        </p>
      </div>

      <!-- Form -->
      <form class="mt-8 space-y-5 relative z-10" @submit.prevent="login">
        <!-- Username -->
        <div>
          <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Lietotājvārds</label>
          <input
            id="username"
            type="text"
            placeholder="Ievadi lietotājvārdu"
            v-model="username"
            class="w-full rounded-xl border border-gray-700 bg-gray-800/60 px-4 py-2 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
          />
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Parole</label>
          <input
            id="password"
            type="password"
            placeholder="Ievadi paroli"
            v-model="password"
            class="w-full rounded-xl border border-gray-700 bg-gray-800/60 px-4 py-2 text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
          />
        </div>

        <!-- Remember me + Forgot password -->
        <div class="flex items-center justify-between text-sm">
          <label class="flex items-center text-gray-400">
            <input
              type="checkbox"
              class="h-4 w-4 rounded border-gray-600 bg-gray-800 text-indigo-500 focus:ring-indigo-400"
            />
            <span class="ml-2">Atcerēties mani</span>
          </label>
          <RouterLink
            to="/forgot-password"
            class="font-medium text-indigo-400 hover:text-indigo-300 transition"
          >
            Aizmirsi paroli?
          </RouterLink>
        </div>

        <!-- Submit button -->
        <button
          type="submit"
          class="w-full rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 py-2.5 text-white font-semibold shadow-lg hover:opacity-90 active:scale-[.98] transition"
        >
          Pieslēgties
        </button>

        <!-- Register redirect -->
        <p class="text-center text-gray-400 text-sm pt-2">
          Tev nav konta?
          <RouterLink
            to="/registracija"
            class="text-indigo-400 hover:text-indigo-300 font-medium transition"
          >
            Reģistrēties
          </RouterLink>
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { RouterLink } from "vue-router";
import api from "../services/api.js";

const username = ref("");
const password = ref("");

const login = async () => {
  try {
    const response = await api.post("/login", {
      username: username.value,
      password: password.value,
    });
    localStorage.setItem("role", response.data.user.role);
    localStorage.setItem("token", response.data.token);
    window.location.href = "/profile";
  } catch (err) {
    console.error(err.response?.data || err);
    alert("Nepareizs lietotājvārds vai parole");
  }
};
</script>

<style scoped>
/* match home and vakances style */
body {
  background-color: #0b0c10;
}
</style>
