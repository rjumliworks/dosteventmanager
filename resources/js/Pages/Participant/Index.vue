<template>
    {{$page.props.participant.data}}
   <form @submit.prevent="logout">
    <BButton variant="none" type="submit" class="btn p-0">
      <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Logout
    </BButton>
  </form>
</template>
<script>
export default {
    layout: null,
    methods: {
        async logout() {
        try {
            await axios.get('/participant/logout')
            window.location.href = '/participant/login' // redirect manually after logout
        } catch (error) {
            console.error('Logout failed:', error)
        }
        }
    }
}
</script>