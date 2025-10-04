<script setup>
import api from "@fms/utils/api";
import openBook from '@/../icons/open_book_3d.png';
import pencil from '@/../icons/pencil_3d.png';
import puzzlePiece from '@/../icons/puzzle_piece_3d.png';
import bookmarkTabs from '@/../icons/bookmark_tabs_3d.png';
import okHand from '@/../icons/ok_hand_3d_default.png';
import greenBook from '@/../icons/green_book_3d.png';
import moneyBag from '@/../icons/money_bag_3d.png';

import VerticalNavSectionTitle from '@fms/@layouts/components/VerticalNavSectionTitle.vue';
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';



const user = ref(null); // hold user data

onMounted(async () => {
  try {
    const { data } = await api.get("/user"); 
    user.value = data;
  } catch (err) {
    console.error("Failed to fetch user:", err.response?.data || err.message);
  }
});
</script>
<template>
  <!-- 👉 If Admin -->
  <template v-if="user && user.is_admin">
    <VerticalNavGroup
      :item="{
        title: 'Dashboards',
        badgeContent: '5',
        badgeClass: 'bg-error',
        icon: 'bx-home-smile',
      }"
    >
      <VerticalNavLink
        :item="{
          title: 'Analytics',
          to: '/dashboard',
        }"
      />
    </VerticalNavGroup>

    <VerticalNavSectionTitle
      :item="{ heading: 'Review Center' }"
    />
    <VerticalNavLink
      :item="{
        title: 'For Approval',
        icon: okHand,
        href: '/login',
      }"
    />
    <VerticalNavSectionTitle
      :item="{ heading: 'Department Requests' }"
    />
    <VerticalNavLink
      :item="{
        title: 'Program Appropriation',
        icon: puzzlePiece,
        href: '/pao',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Obligation Requests',
        icon: greenBook,
        href: '/login',
      }"
    />

    <VerticalNavSectionTitle
      :item="{ heading: 'Management' }"
    />
    <VerticalNavLink
      :item="{
        title: 'Budget Allotment',
        icon: moneyBag,
        href: '/annual-budget',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Office Codes',
        icon: openBook,
        href: '/office-codes',
      }"
    />
    <VerticalNavLink
      :item="{
        title: 'Expenditures',
        icon: pencil,
        href: '/expenditures',
      }"
    />

    <VerticalNavSectionTitle
      :item="{ heading: 'Settings' }"
    />
    <VerticalNavLink
      :item="{
        title: 'Paper Trail Management',
        icon: bookmarkTabs,
        href: '/login',
      }"
    />
  </template>

  <!-- 👉 If NOT Admin -->
  <template v-else-if="user && !user.is_admin">
    <VerticalNavSectionTitle
      :item="{ heading: 'Review Center' }"
    />
    <VerticalNavLink
      :item="{
        title: 'For Approval',
        icon: okHand,
        href: '/login',
      }"
    />
  </template>
</template>
