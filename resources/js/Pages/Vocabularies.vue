<template>
    <div class="app-container mt-5">
        <div class="d-flex justify-content-between">
            <h3>Vocabularies</h3>
            <Link class="text-decoration-none" href="/">Home</Link>
        </div>
        <p v-if="error" class="form-text text-danger">{{ error }}</p>
        <!-- Show loading on while processing -->
        <svg v-if="processing" style="width: 50px; height: 50px;" xmlns="http://www.w3.org/2000/svg"
             x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <path fill="#333"
                  d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
              <animateTransform
                  attributeName="transform"
                  attributeType="XML"
                  type="rotate"
                  dur="1s"
                  from="0 50 50"
                  to="360 50 50"
                  repeatCount="indefinite"/>
          </path>
        </svg>

        <table class="table table-sm table-bordered table-hover table-striped my-3" v-if="vocabularies.length">
            <thead>
            <tr>
                <th>Word</th>
                <th>Meaning</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(vocabulary,index) in vocabularies" :key="index">
                <td class="w-25">{{ vocabulary.word }}</td>
                <td>{{ vocabulary.meaning.join(', ') }}</td>
                <td>
                    <label class="badge btn btn-danger" @click="removeVocabulary(index)">Remove from vocabulary</label>
                </td>
            </tr>
            </tbody>
        </table>

        <p v-else>No vocabulary found in database</p>
    </div>
</template>

<script setup>
import {ref} from "vue";

const props = defineProps({
    vocabularies: {
        type: Array,
        default: []
    }
})
const error = ref('');
const processing = ref(false);
const removeVocabulary = (index) => {
    // Remove vocabulary
    axios.delete(`vocabularies/${props.vocabularies[index].id}`).then((response) => {
        if (response.data.success) {
            props.vocabularies.splice(index, 1);
        }
        processing.value = false;
    }).catch(function (error_response) {
        if (error_response.response.data) {
            console.log(error_response.response.data.message);
            error.value = error_response.response.data.message;
        }
        processing.value = false;
    });
}

</script>

<style scoped>
.app-container {
    margin: auto;
    max-width: 700px;
}
</style>