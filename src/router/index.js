/**
* router/index.ts
*
* Automatic routes for `./src/pages/*.vue`
*/

// Composables
import { createRouter, createWebHistory } from 'vue-router/auto'
import { setupLayouts } from 'virtual:generated-layouts'
import { routes } from 'vue-router/auto-routes'

// Custom routes for specific pages
const customRoutes = [
{
path: '/acceuil',
component: () => import('@/layouts/default.vue'),
children: [
{
path: '',
name: 'Accueil',
component: () => import('@/pages/accueil.vue'),
},
],
},
{
path: '/catalogue',
component: () => import('@/layouts/default.vue'),
children: [
{
path: '',
name: 'Catalogue',
component: () => import('@/pages/catalogue.vue'),
},
],
},
{
path: '/panier',
component: () => import('@/layouts/default.vue'),
children: [
{
path: '',
name: 'Panier',
component: () => import('@/pages/panier.vue'),
},
],
},
{
path: '/profil',
component: () => import('@/layouts/default.vue'),
children: [
{
path: '',
name: 'Profil',
component: () => import('@/pages/profil.vue'),
},
],
},
{
path: '/connexion',
component: () => import('@/layouts/default.vue'),
children: [
{
path: '',
name: 'Connexion',
component: () => import('@/pages/connexion.vue'),
},
],
},
{
path: '/inscription',
component: () => import('@/layouts/default.vue'),
children: [
{
path: '',
name: 'Inscription',
component: () => import('@/pages/inscription.vue'),
},
],
},
{
path: '/modification',
component: () => import('@/layouts/default.vue'),
children: [
{
path: '',
name: 'Modification',
component: () => import('@/pages/modification.vue'),
},
],
},
]

// Merge automatic routes and custom routes
const mergedRoutes = [...setupLayouts(routes), ...customRoutes]

const router = createRouter({
history: createWebHistory(import.meta.env.BASE_URL),
routes: mergedRoutes,
})

// Handle dynamic import errors
router.onError((err, to) => {
if (err?.message?.includes?.('Failed to fetch dynamically imported module')) {
if (!localStorage.getItem('vuetify:dynamic-reload')) {
console.log('Reloading page to fix dynamic import error')
localStorage.setItem('vuetify:dynamic-reload', 'true')
location.assign(to.fullPath)
} else {
console.error('Dynamic import error, reloading page did not fix it', err)
}
} else {
console.error(err)
}
})

// Cleanup on ready
router.isReady().then(() => {
localStorage.removeItem('vuetify:dynamic-reload')
})

export default router