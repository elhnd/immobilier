<template>
  <div class="conteiner">
    <!-- bien -->

    <div class="row mt-5" v-if="$gate.isAdminOrBailleurs()">
      <div class="col-md-12" v-if="showTab">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">liste des location</h3>

            <div class="card-tools">
              <!-- <button class="btn btn-success" @click="newModal">
                <i class="fas fa-user-plus fa fw"></i> Ajouter Equipement
              </button>-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table id="table" class="table table-hover">
              <thead>
                <tr>
                  <th>Nom complet</th>
                  <th>Téléphone</th>
                  <th>adresse</th>
                  <th>Bien</th>
                  <th>prix</th>
                  <th>Caution</th>
                  <th>Référence</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="operation in Operation.data" :key="operation.id">
                  <td>{{operation.prenom}} {{operation.nom}}</td>
                  <td>{{operation.tel}}</td>
                  <td>{{operation.adresse}}</td>
                  <td>{{operation.details}}</td>
                  <td>{{operation.prix}}</td>
                  <td>{{operation.caution}}</td>
                  <td>{{operation.ref}}</td>
                  <td>
                    <button class="btn btn-success" @click="detail(operation)">
                      <i class="fas fa-rent-plus fa fw"></i> detail
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="Operation" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <div v-if="!$gate.isAdminOrBailleurs()">
      <not-found></not-found>
    </div>
    <section class="content" v-if="detailShow">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> ALAWA.
                    <small class="float-right">Date: {{date|myDate}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h3>propriétaire</h3>
                  <address>
                    <strong>alawa.</strong>
                    <br />alawa
                    <br />alawa
                    <br />Phone: alawa
                    <br />Email: info@alawa.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>locataire</h3>
                  <address>
                    <strong>{{details.prenom}}</strong>
                    <strong>{{details.nom}}</strong>

                    <br />
                    Phone: {{details.tel}}
                    <br />
                    sexe: {{details.sexe}}
                    <br />
                    adresse: {{details.adresse}}
                    <br />
                    profession: {{details.profession}}
                    <br />
                    nationalité: {{details.nationalite}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>Bien</h3>

                  <b>Bien:</b>
                  {{details.details}}
                  <br />
                  <b>Prix:</b>
                  {{details.prix}}
                  <br />
                  <b>Adresse:</b>
                  {{details.adresse}}
                  <br />
                  <b>référence location:</b>
                  {{details.ref}}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="form-row">
                <div
                  class="col row no-print"
                  @click="dernier(details.dernierelevé)"
                  v-if="details.dernierelevé"
                >
                  <button type="button" class="btn btn-success float-right">
                    <i class="fas fa-download"></i>
                    dernier relevé
                  </button>
                </div>
                <div class="col row no-print" @click="piece(details.piece)" v-if="details.piece">
                  <button type="button" class="btn btn-primary float-right">
                    <i class="fas fa-print"></i>
                    piece
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

    <section class="row no-print" v-if="detailShow">
      <form @submit.prevent="Paiement">
        <div class="form-row">
          <div class="col">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">mois</div>
              </div>
              <input
                v-model="form.date"
                type="month"
                class="form-control"
                name="date"
                placeholder="mois"
                :class="{ 'is-invalid': form.errors.has('date') }"
              />
              <has-error :form="form" field="date"></has-error>
            </div>
          </div>
          <div class="col">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">fcfa</div>
              </div>
              <input
                v-model="form.charge"
                type="text"
                class="form-control"
                name="charge"
                placeholder="charge"
                :class="{ 'is-invalid': form.errors.has('charge') }"
              />
              <has-error :form="form" field="date"></has-error>
            </div>
          </div>
          <div class="col">
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">fcfa</div>
              </div>
              <input
                v-model="form.montant"
                type="text"
                class="form-control"
                name="montant"
                placeholder="montant"
                :class="{ 'is-invalid': form.errors.has('montant') }"
              />
              <has-error :form="form" field="date"></has-error>
            </div>
          </div>
        </div>
        <div class="col" style="margin-left:41px;margin-top:10px">
          <div class="form-group">
            <input type="checkbox" v-model="form.tva" />
            <label class="form-control-label">TVA</label>
          </div>

          <div class="form-group">
            <input type="checkbox" v-model="form.teom" />
            <label class="form-control-label">TEOM</label>
          </div>
          <div class="form-group">
            <input type="checkbox" v-model="form.de" />
            <label class="form-control-label">DE</label>
          </div>
        </div>
        <div class="col" style="margin-left:41px">
          <button type="submit" class="btn btn-primary mb-2">Paiement</button>
        </div>
      </form>
    </section>
    <!-- /.content -->
    <section class="content" v-if="recu">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> ALAWA.
                    <small class="float-right">Date: {{date|myDate}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h3>propriétaire</h3>
                  <address>
                    <strong>alawa.</strong>
                    <br />alawa
                    <br />alawa
                    <br />Phone: alawa
                    <br />Email: info@alawa.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>locataire</h3>
                  <address>
                    <strong>{{details.prenom}}</strong>
                    <strong>{{details.nom}}</strong>

                    <br />
                    Phone: {{details.tel}}
                    <br />
                    sexe: {{details.sexe}}
                    <br />
                    adresse: {{details.adresse}}
                    <br />
                    profession: {{details.profession}}
                    <br />
                    nationalité: {{details.nationalite}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h3>Bien</h3>

                  <b>Bien:</b>
                  {{details.details}}
                  <br />
                  <b>Prix:</b>
                  {{details.prix}}
                  <br />
                  <b>Adresse:</b>
                  {{details.adresse}}
                  <br />
                  <b>référence location:</b>
                  {{details.ref}}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div>
                <H4 class="text-center">
                  ATTESTATION DE
                  BON PAIEMENT DES LOYERS
                </H4>
                <p>
                  Je soussigné(e), M / Mme*
                  ALAWA GÉRANT.
                </p>
                <p>Propriétaire du bien ALAWA</p>
                <p>Certifie par la présente que :</p>
                <p>
                  M / Mme*
                  <strong>{{details.prenom}}</strong>
                  <strong>{{details.nom}}</strong>.
                </p>
                <p>
                  Est/sont* à jour dans le règlement de son/leur* loyer et charges depuis son/leur* entrée dans le
                  logement, en date du {{details.dateEntre}}
                </p>
                <p>Loyer mensuel : {{details.montantPaye}} fcfa</p>
                <p>Charges mensuelles : ………………………… fcfa</p>
                <p>La présente attestation est remise à l’intéressé pour servir et valoir ce que de droit.</p>
                <p class="text-right">Fait à Dakar, le {{date|myDate}}</p>
                <p class="text-right">Signature</p>
              </div>
              <!-- /.col -->

              <div class="row no-print">
                <div class="col-12">
                  <button type="button" class="btn btn-success float-right" @click="printDetails()">
                    <i class="fas fa-download"></i>
                    imprimer
                  </button>&nbsp;
                  <button type="button" class="btn btn-danger float-right" @click="Annuler()">
                    <i class="fas fa-trash"></i>
                    Annuler
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
    setTimeout(function() {
      $("#table").DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
      });
    }, 2000);
  },
  components: {
    "not-found": notFoundComponentVue
  },
  data() {
    return {
      Operation: {},
      details: {},
      detailShow: false,
      showTab: true,
      recu: false,
      date: new Date(),
      form: new Form({
        numero: "",
        operation_id: "",
        biens: "",
        montantPaye: "",
        date: "",
        bien_id: "",
        bailleur: "",
        commission: "",
        prix: "",
        montant: "",
        tel: "",
        tva: false,
        teom: false,
        de: false,
        charge: ""
      })
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/paiementactif?page=" + page).then(response => {
        this.Operation = response.data;
      });
    },
    Annuler() {
      location.reload();
    },
    printDetails() {
      window.print();
      this.recu = false;
      this.showTab = true;
    },
    print() {
      this.recu = true;
    },
    dernier(e) {
      window.open("img/profile/" + e);
    },
    piece(e) {
      window.open("img/profile/" + e);
    },
    Paiement() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form.numero = this.details.numero;
      this.form.operation_id = this.details.operation_id;
      this.form.biens = this.details.biens;
      this.form.montantPaye = this.details.montantPaye;
      this.form.bien_id = this.details.bien_id;
      this.form.bailleur = this.details.bailleur;
      this.form.commission = this.details.commission;
      this.form.prix = this.details.prix;
      this.form.tel = this.details.tel;
      this.form
        .post("/api/paiement")
        .then(response => {
          let message = response.data.message;
          let status = response.data.status;

          if (status == 500) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: message
            });
          }
          if (status == 200) {
            Toast.fire({
              icon: "success",
              title: message
            });
            this.getResults();
            Fire.$emit("AfterCreate");
            this.$Progress.finish();
            this.showTab = false;
            this.recu = true;
            this.detailShow = false;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },
    detail(e) {
      this.detailShow = true;
      this.details = e;
    },

    created() {
      this.loadOperation();
      Fire.$on("AfterCreate", () => {
        this.loadOperation();
      });
      //setInterval(()=>this.loadOperation(),10000)
    }
  }
};
</script>
<style >
.form-row {
  display: -webkit-box;
  display: flex;
  flex-wrap: wrap;
  margin-left: 50px;
}
</style>