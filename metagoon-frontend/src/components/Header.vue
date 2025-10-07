```vue
<template>
  <header
    v-if="!hideHeader"
    class="sticky top-0 z-40 w-full border-b border-black/10 bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:bg-gray-900/70 dark:border-white/10"
  >
    <div class="h-0.5 w-full bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-cyan-400"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6">
      <div class="flex h-16 items-center justify-between">
        <!-- Logo -->
        <RouterLink to="/" class="flex items-center gap-2 group">
          <span
            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-black text-white shadow-sm group-hover:scale-105 transition"
          >
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor">
              <path
                d="M12 2a2 2 0 0 1 1.79 1.1l7 14A2 2 0 0 1 19 20H5a2 2 0 0 1-1.79-2.9l7-14A2 2 0 0 1 12 2z"
              />
            </svg>
          </span>
          <h1 class="text-2xl font-extrabold tracking-tight">
            <span
              class="bg-gradient-to-r from-black via-gray-800 to-black bg-clip-text text-transparent dark:from-white dark:via-gray-200 dark:to-white"
            >
              MetaGoon
            </span>
          </h1>
        </RouterLink>

        <!-- Navigation -->
        <nav class="flex items-center gap-6 font-semibold">
          <NavLink to="/" label="Sākums" />
          <NavLink to="/vakances" label="Vakances" />
          <NavLink to="/favoriti" label="Favorīti" />
          <!-- ✅ Only visible for employers -->
          <NavLink
            v-if="isLoggedIn && userRole === 'uzņēmējs'"
            to="/applications"
            label="Pieteikumi"
          />
        </nav>

        <!-- Auth Buttons -->
        <div class="flex items-center gap-3">
          <template v-if="isLoggedIn">
            <RouterLink
              to="/profile"
              class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800 transition"
            >
              Profils
            </RouterLink>
            <button
              @click="logout"
              class="rounded-xl bg-red-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-600 active:scale-[.99] transition"
            >
              Izrakstīties
            </button>
          </template>

          <template v-else>
            <RouterLink
              to="/login"
              class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800 transition"
            >
              Pieslēgties
            </RouterLink>
            <RouterLink
              to="/registracija"
              class="rounded-xl bg-black px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-100 transition"
            >
              Reģistrēties
            </RouterLink>
          </template>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { RouterLink, useRoute } from "vue-router";
import { ref, computed, onMounted, defineComponent, h } from "vue";

const route = useRoute();
const hideHeader = computed(() => route.meta.hideHeader);

const isLoggedIn = ref(false);
const userRole = ref(null);

onMounted(() => {
  isLoggedIn.value = !!localStorage.getItem("token");
  userRole.value = localStorage.getItem("role");
});

const logout = () => {
  localStorage.removeItem("token");
  localStorage.removeItem("role");
  isLoggedIn.value = false;
  window.location.href = "/";
};

const NavLink = defineComponent({
  name: "NavLink",
  props: {
    to: { type: String, required: true },
    label: { type: String, required: true },
  },
  setup(props) {
    const route = useRoute();
    const active = computed(() => route.path === props.to);

    return () =>
      h(
        RouterLink,
        {
          to: props.to,
          class: [
            "relative px-2 py-1 text-[15px] transition",
            active.value
              ? "text-black dark:text-white"
              : "text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400",
          ],
        },
        {
          default: () => [
            h("span", { class: "inline-block" }, props.label),
            h("span", {
              class: [
                "absolute left-0 -bottom-1 h-0.5 w-full rounded-full transition-all",
                active.value ? "bg-blue-600 scale-100" : "bg-transparent scale-0",
              ],
            }),
          ],
        }
      );
  },
});
</script>

