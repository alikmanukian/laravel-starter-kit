<script setup>
import NavLinks from '@/Components/App/Navigation/NavLinks.vue'
import TeamsDropdown from '@/Components/App/Navigation/TeamsDropdown.vue'
import UserDropdown from '@/Components/App/Navigation/UserDropdown.vue'
import Container from '@/Components/App/Container.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import ResponsiveNavLink from '@/Components/App/Navigation/ResponsiveNavLink.vue'
import TeamSwitcher from '@/Components/App/Navigation/TeamSwitcher.vue'
import Hamburger from '@/Components/App/Navigation/Hamburger.vue'
import { ref } from 'vue'
import { isAuthorized, isCurrentRoute } from '@/helpers.js'

const showingNavigationDropdown = ref(false)

let mainMenu = ref([])
let authMenu = ref([])
let userMenu = ref([])
let teamMenu = ref([])
let page = ref(usePage())

router.on('navigate', () => {
    page.value = usePage()

    mainMenu.value = [
        {
            name: 'Home',
            href: route('home'),
            current: isCurrentRoute('home'),
            show: !isAuthorized(),
        },
        {
            name: 'Dashboard',
            href: route('dashboard'),
            current: isCurrentRoute('dashboard'),
            show: isAuthorized(),
        },
    ]

    authMenu.value = [
        {
            name: 'Login',
            href: route('login'),
            current: isCurrentRoute('login'),
        },
        {
            name: 'Register',
            href: route('register'),
            current: isCurrentRoute('register'),
        },
    ]

    userMenu.value = [
        {
            name: 'Profile',
            href: route('profile.show'),
            current: isCurrentRoute('profile.show'),
        },
        {
            name: 'API Tokens',
            href: page.value.props.jetstream.hasApiFeatures
                ? route('api-tokens.index')
                : '',
            current: isCurrentRoute('api-tokens.index'),
            show: page.value.props.jetstream.hasApiFeatures,
        },
    ]

    teamMenu.value = [
        {
            name: 'Team Settings',
            href: page.value.props.jetstream.canCreateTeams
                ? route('teams.show', page.value.props.auth.user?.current_team)
                : '',
            current: isCurrentRoute('teams.show'),
        },
        {
            name: 'Create New Team',
            href: page.value.props.jetstream.canCreateTeams
                ? route('teams.create')
                : '',
            current: isCurrentRoute('teams.create'),
            show: page.value.props.jetstream.canCreateTeams,
        },
    ]
})

const switchToTeam = (team) => {
    router.put(
        route('current-team.update'),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        },
    )
}

const logout = () => {
    router.post(route('logout'))
}
</script>

<template>
    <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <Container class="px-4">
            <div class="flex justify-between h-16">
                <!-- Left side -->
                <div class="flex flex-1">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('home')">
                            <img
                                src="/images/icons/svg/jetstream-logo.svg"
                                class="block h-9 w-auto"
                            />
                        </Link>
                    </div>

                    <!-- Main Menu -->
                    <NavLinks
                        :items="mainMenu"
                        class="sm:ms-10 hidden space-x-8 sm:-my-px sm:flex"
                    />

                    <slot name="left-side" />
                </div>

                <!-- Right side -->
                <div class="flex sm:ms-6">
                    <slot name="right-side" />

                    <div class="ms-3 relative empty:hidden hidden sm:flex">
                        <!-- Teams Dropdown -->
                        <TeamsDropdown
                            v-if="$page.props.jetstream.hasTeamFeatures"
                            :items="teamMenu"
                            @change-team="switchToTeam"
                        />

                        <!-- Login/Register links -->
                        <NavLinks
                            v-if="!$page.props.auth.user"
                            class="hidden space-x-4 sm:-my-px sm:flex"
                            :items="authMenu"
                        />

                        <!-- Settings Dropdown -->
                        <UserDropdown
                            v-if="$page.props.auth.user"
                            class="items-center hidden sm:flex"
                            @logout="logout"
                        />
                    </div>
                </div>

                <!-- Hamburger -->
                <Hamburger
                    class="-me-2 flex items-center sm:hidden"
                    :opened="showingNavigationDropdown"
                    @toggle="(value) => (showingNavigationDropdown = value)"
                />
            </div>
        </Container>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{
                block: showingNavigationDropdown,
                hidden: !showingNavigationDropdown,
            }"
            class="sm:hidden"
        >
            <div class="pt-2 pb-3 space-y-1">
                <NavLinks :items="mainMenu" responsive />
                <NavLinks
                    v-if="!$page.props.auth.user"
                    :items="authMenu"
                    responsive
                />
            </div>

            <!-- Responsive Settings Options -->
            <div
                v-if="$page.props.auth.user"
                class="pt-4 pb-1 border-t border-gray-200"
            >
                <div class="flex items-center px-4">
                    <div
                        v-if="$page.props.jetstream.managesProfilePhotos"
                        class="shrink-0 me-3"
                    >
                        <img
                            class="h-10 w-10 rounded-full object-cover"
                            :src="$page.props.auth.user.profile_photo_url"
                            :alt="$page.props.auth.user.name"
                        />
                    </div>

                    <div>
                        <div class="font-medium text-base text-gray-800">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <NavLinks :items="userMenu" responsive />

                    <!-- Authentication -->
                    <form method="POST" @submit.prevent="logout">
                        <ResponsiveNavLink as="button">
                            Log Out
                        </ResponsiveNavLink>
                    </form>

                    <!-- Team Management -->
                    <template v-if="$page.props.jetstream.hasTeamFeatures">
                        <div class="border-t border-gray-200" />

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Manage Team
                        </div>

                        <!-- Team Settings -->
                        <NavLinks :items="teamMenu" responsive />

                        <!-- Team Switcher -->
                        <TeamSwitcher responsive @change="switchToTeam" />
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>
