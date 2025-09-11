<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>


  <v-app>

    

<v-app-bar app color="warning" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>My Application</v-toolbar-title>
       <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" app>
      <v-list>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-h6">
              <Link href="/">
                <ApplicationLogo class="h-10 w-10 fill-current text-gray-500" />
              </Link>
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list-item link>
          <v-list-item-icon>
            <v-icon>mdi-home</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <Link href="/">Home</Link>
          </v-list-item-content>
        </v-list-item>

        <!-- Add more navigation items here -->
      </v-list>
    </v-navigation-drawer>

    

    <v-main>
      <slot />
    </v-main>

    <v-footer app color="warning" dark>
      <span class="white--text">&copy; 2024 My Application</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      drawer: true, // Controls the visibility of the navigation drawer
    };
  },
};
</script>

<style scoped>
/* Optional styling for your components */
</style>