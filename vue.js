<template>
  <div>
    <h2>Lista klientów</h2>
    <ul>
      <li v-for="client in clients" :key="client.id">
        {{ client.name }}
      </li>
    </ul>

    <h2>{{ mode === 'add' ? 'Dodaj klienta' : 'Edytuj klienta' }}</h2>
    <form @submit="handleSubmit">
      <input v-model="formData.name" type="text" placeholder="Imię i nazwisko">
      <input v-model="formData.email" type="email" placeholder="Email">
      <button type="submit">{{ mode === 'add' ? 'Dodaj' : 'Zapisz' }}</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      mode: 'add',
      clients: [],
      formData: {
        name: '',
        email: ''
      }
    };
  },
  mounted() {
    this.fetchClients();
  },
  methods: {
    fetchClients() {
      axios.get('/api/clients')
        .then(response => {
          this.clients = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    handleSubmit(event) {
      event.preventDefault();
      if (this.mode === 'add') {
        this.addClient();
      } else {
        this.editClient();
      }
    },
    addClient() {
      axios.post('/api/clients', this.formData)
        .then(response => {
          this.clients.push(response.data);
          this.resetForm();
        })
        .catch(error => {
          console.log(error);
        });
    },
    editClient() {
      axios.put(`/api/clients/${this.clientId}`, this.formData)
        .then(response => {
          this.fetchClients();
          this.resetForm();
        })
        .catch(error => {
          console.log(error);
        });
    },
    resetForm() {
      this.mode = 'add';
      this.formData = {
        name: '',
        email: ''
      };
    }
  }
};
</script>





{/* Przepisz poniższy fragment kodu na bardziej czytelny zapis
arrA.filter(x => !arrB.includes(x)).concat(arrB.filter(x => !arrA.includes(x))) */}

const arrA = [...]; // tablica A
const arrB = [...]; // tablica B

const arrANotInB = arrA.filter(item => !arrB.includes(item)); // Elementy z tablicy A, które nie występują w tablicy B
const arrBNotInA = arrB.filter(item => !arrA.includes(item)); // Elementy z tablicy B, które nie występują w tablicy A

const result = arrANotInB.concat(arrBNotInA); // Połączenie wynikowych tablic

console.log(result);