<template>
 <v-content>
  <v-container fluid fill-height>
        <div v-show="loader" style="text-align: center; width: 100%;">
          <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
        </div>
   <v-layout justify-center align-center v-show="!loader">
    <div class="wrapper">
      <div class="content">
        <div class="row">

          <div class="col-md-3 col-sm-6">
            <div class="card card-stats" style="background: #E91E63;color: #fff;">
              <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                  <!-- <i class="fa fa-user"></i> -->
                  <!-- <i class="material-icons">account_circle</i> -->
                </div>
                <p class="card-category">Clients</p>
                <h3 class="card-title">{{ AllBuyers.length }} <small>Client</small></h3>
              </div>
              <div class="card-footer">
                 <!--<div class="stats">
                  <i class="material-icons text-danger">warning</i> -->
                  <!-- <a href="#">Go to Clients</a> 
                </div>-->
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6">
            <div class="card card-stats" style="    background: #03A9F4;
    color: #fff;">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <!-- <i class="material-icons">store</i> -->
                </div>
                <p class="card-category">Deliveries</p>
                <h3 class="card-title">100</h3>
                <!-- <h3 class="card-title">{{ AllDeriveries.length }}</h3> -->
              </div>
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons">Date range</i> Last 72 Hours -->
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="card card-stats" style="background: #FF9800;
    color: #fff;">
              <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                  <!-- <i class="material-icons">info_outline</i> -->
                </div>
                <p class="card-category">Societies</p>
                <h3 class="card-title">{{ AllSocieties.length }}</h3>
                <!-- <h3 class="card-title">{{ AllSocieties.length }}</h3> -->
              </div>
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons">local_offer</i> Tracked from Email -->
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="card card-stats" style="background: #607D8B;
    color: #fff;">
              <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                  <!-- <i class="material-icons">comment</i> Tracked from Github -->
                </div>
                <p class="card-category">Milled Coffee (KG)</p>
                <h3 class="card-title">2500</h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons">update</i> Just Updated -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6 col-md-12" style="margin-top: 50px;">
          <div class="card">
            <div class="card-header card-header-primary" style="    background: #f00;
    color: #fff;">
              <h4 class="card-title">Recent Users</h4>
              <p class="card-category">This are the recent app Users</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <tr><th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                  </tr>
                </thead>
                  <tbody>
                    <tr v-for="users in FewUsers" :key="users.id">
                      <td>{{ users.name }}</td>
                      <td>{{ users.email }}</td>
                      <td>{{ users.phone }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Comments -->
          <div class="col-lg-6 col-md-12" style="margin-top: 50px;">
          <div class="card">
            <div class="card-header card-header-warning"  style="    background: #f00;
    color: #fff;">
              <h4 class="card-title">Recent Clients</h4>
              <p class="card-category">Recent Clients</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                  </tr>
                </thead>
                  <tbody>
                    <tr v-for="buyer in FewBuyers" :key="buyer.id">
                      <td>{{ buyer.name }}</td>
                      <td>{{ buyer.email }}</td>
                      <td>{{ buyer.phone }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Comments -->
          <div class="col-lg-6 col-md-12" style="margin-top: 50px;">
          <div class="card">
            <div class="card-header card-header-info" style="    background: #f00;
    color: #fff;">
              <h4 class="card-title">Recent Societies</h4>
              <p class="card-category">Recent Societies</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-info">
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                  </tr></thead>
                  <tbody>
                    <tr v-for="society in FewSocieties" :key="society.id">
                      <td>{{ society.name }}</td>
                      <td>{{ society.email }}</td>
                      <td>{{ society.phone }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


        </div>
      </div>
      </v-layout>
  </v-container>
 </v-content>
</template>

<script>
export default {
 data() {
  return{
   AllBuyers: {},
   loader: false,
   AllDeriveries: {},
   AllSocieties: {},
   AllSubscribers: {},
   notCompleted: {},
   Allcomments: {},
   FewUsers: {},
   FewBuyers: {},
   FewSocieties: {},
 }
},
mounted() {
  this.loader = true
  axios.post('getBuyers')
  .then((response) => {
    this.AllBuyers = response.data
  })
  .catch((error) => {
    this.errors = error.response.data.errors
  })

  axios.post('getderivery')
  .then((response) => {
    this.AllDeriveries = response.data
  })
  .catch((error) => {
    this.errors = error.response.data.errors
  })

  axios.post('getSociety')
  .then((response) => {
    this.AllSocieties = response.data
        this.loader = false
  })
  .catch((error) => {
        this.loader = false
    this.errors = error.response.data.errors
  })

    axios.post('fewBuyers')
    .then((response) => {
      this.FewBuyers = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('fewUsers')
    .then((response) => {
      this.FewUsers = response.data
    })
    .catch((error) => {
      this.errors = error.response.data.errors
    })

    axios.post('fewSocieties')
    .then((response) => {
        this.loader = false
      this.FewSocieties = response.data
    })
    .catch((error) => {
        this.loader = false
      this.errors = error.response.data.errors
    })
  }
}
</script>

