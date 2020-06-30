<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Generer un rapport
      </a>
    </div>

    <div class="row">
      <!-- ============================================================== -->
      <!-- sales  -->
      <!-- ============================================================== -->

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Biens</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{bien}}</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-green"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-home fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end sales  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">CLIENTS</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{client}}</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-warning"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-male fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end new customer  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">BAILLEURS</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{bailleur}}</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-info"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-alt fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end visitor  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- total orders  -->
      <!-- ============================================================== -->
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">UTILISATEURS</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{user}}</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-dark"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end total orders  -->
      <!-- ============================================================== -->
    </div>
    <div class="row">
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- total orders  -->
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- end total orders  -->

      <!-- Earnings (Monthly) Card Example -->

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">SOLDE ALAWA</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div
                      class="h5 mb-0 mr-3 font-weight-bold text-gray-800"
                    >{{Soldealawa[0].solde}} fcfa</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-green"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-money-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">COMMISSION</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div
                      class="h5 mb-0 mr-3 font-weight-bold text-gray-800"
                    >{{Commission[0].commission}} fcfa</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-green"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-money-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">SOLDE BAILLEURS</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div
                      class="h5 mb-0 mr-3 font-weight-bold text-gray-800"
                    >{{soldeBailleur[0].solde}} fcfa</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-info"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-money-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pending Requests Card Example -->

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">SOLDE CLIENTS</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div
                      class="h5 mb-0 mr-3 font-weight-bold text-gray-800"
                    >{{sommeClient[0].solde}} fcfa</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-warning"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-money-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">TVA</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{soldeTVA}} fcfa</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-danger"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-money-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end new customer  -->

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">TEOM</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{soldeTEOM}} fcfa</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-danger"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-money-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end new customer  -->

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">DE</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{soldeDE}} fcfa</div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-danger"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-money-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end new customer  -->

      <div class="row">
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
          <!-- Project Card Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
            </div>
            <div class="card-body">
              <h4 class="small font-weight-bold">
                Server Migration
                <span class="float-right">20%</span>
              </h4>
              <div class="progress mb-4">
                <div
                  class="progress-bar bg-danger"
                  role="progressbar"
                  style="width: 20%"
                  aria-valuenow="20"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
              <h4 class="small font-weight-bold">
                Sales Tracking
                <span class="float-right">40%</span>
              </h4>
              <div class="progress mb-4">
                <div
                  class="progress-bar bg-warning"
                  role="progressbar"
                  style="width: 40%"
                  aria-valuenow="40"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
              <h4 class="small font-weight-bold">
                Customer Database
                <span class="float-right">60%</span>
              </h4>
              <div class="progress mb-4">
                <div
                  class="progress-bar"
                  role="progressbar"
                  style="width: 60%"
                  aria-valuenow="60"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
              <h4 class="small font-weight-bold">
                Payout Details
                <span class="float-right">80%</span>
              </h4>
              <div class="progress mb-4">
                <div
                  class="progress-bar bg-info"
                  role="progressbar"
                  style="width: 80%"
                  aria-valuenow="80"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
              <h4 class="small font-weight-bold">
                Account Setup
                <span class="float-right">Complete!</span>
              </h4>
              <div class="progress">
                <div
                  class="progress-bar bg-success"
                  role="progressbar"
                  style="width: 100%"
                  aria-valuenow="100"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-4">
          <!-- Illustrations -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
            </div>
            <div class="card-body">
              <div class="text-center">
                <img
                  class="img-fluid px-3 px-sm-4 mt-3 mb-4"
                  style="width: 25rem;"
                  src="img/undraw_posting_photo.svg"
                  alt
                />
              </div>
              <p>
                Add some quality, svg illustrations to your project courtesy of
                <a target="_blank" rel="nofollow" href="#">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!
              </p>
              <a target="_blank" rel="nofollow" href="#">Browse Illustrations on unDraw &rarr;</a>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- end sales  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
    </div>
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  components: {
    "not-found": notFoundComponentVue
  },
  mounted() {
    this.countuser();
    this.countclients();
    this.countbiens();
    this.countbailleurs();
    this.soldebailleur();
    this.sommeclient();
    this.commission();
    this.soldealawa();
    this.de();
    this.tva();
    this.teom();
  },

  data() {
    return {
      user: "",
      bailleur: "",
      client: "",
      bien: "",
      soldeBailleur: "",
      sommeClient: "",
      Commission: "",
      Soldealawa: "",
      soldeTVA: "",
      soldeTEOM: "",
      soldeDE: ""
    };
  },
  methods: {
    countuser() {
      axios.get("api/countuser").then(response => {
        this.user = response.data;
      });
    },
    countclients() {
      axios.get("api/countclients").then(response => {
        this.client = response.data;
      });
    },
    countbailleurs() {
      axios.get("api/countbailleurs").then(response => {
        this.bailleur = response.data;
      });
    },
    countbiens() {
      axios.get("api/countbiens").then(response => {
        this.bien = response.data;
      });
    },
    soldebailleur() {
      axios.get("api/soldebailleur").then(response => {
        this.soldeBailleur = response.data;
      });
    },
    sommeclient() {
      axios.get("api/sommeclient").then(response => {
        this.sommeClient = response.data;
      });
    },
    commission() {
      axios.get("api/commission").then(response => {
        this.Commission = response.data;
      });
    },
    soldealawa() {
      axios.get("api/soldealawa").then(response => {
        this.Soldealawa = response.data;
      });
    },
    tva() {
      axios.get("api/solde-tva").then(response => {
        this.soldeTVA = response.data[0].tva;
      });
    },
    teom() {
      axios.get("api/solde-teom").then(response => {
        this.soldeTEOM = response.data[0].teom;
      });
    },
    de() {
      axios.get("api/solde-de").then(response => {
        this.soldeDE = response.data[0].de;
      });
    }
  }
};
</script>
