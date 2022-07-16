import axios from "axios";
import {API_CURRENT_USER_URL} from "@/api/users";

export default {
    methods: {
        loginUser() {
            this.$store.commit('auth/setIsLoggedIn', true);

            axios.get(API_CURRENT_USER_URL).then((response) => {
                this.$store.commit('auth/setUser', response.data)

                if (this.$route.query.redirect) {
                    this.$router.push(this.$route.query.redirect)
                } else {
                    this.$router.push('/')
                }
            }).catch(errors => {
                console.log(errors.response)
            })
        }
    }
}
