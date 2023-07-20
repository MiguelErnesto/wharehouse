export default class almacenesClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.btnVerProdAlm = document.querySelectorAll('.btnVerProdAlm')
    this.addListeners()
  }

  addListeners = () => {
    this.form
      ? this.form.addEventListener('submit', (evt) => this.onValidate(evt))
      : ''

    if (this.btnDelete) {
      for (var i = 0; i < this.btnDelete.length; i += 1) {
        this.btnDelete[i].addEventListener('click', (evt) => this.onDelete(evt))
      }
    }
    if (this.btnVerProdAlm) {
      for (var i = 0; i < this.btnVerProdAlm.length; i += 1) {
        this.btnVerProdAlm[i].addEventListener('click', (evt) =>
          this.onVerProductosAlmacen(evt),
        )
      }
    }
  }

  onVerProductosAlmacen(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    document.getElementById('titleMdVerProdAlm').innerText =
      'Almacén ' + evt.currentTarget.dataset.nombre
  }

  onDelete(evt) {
    evt.preventDefault()
    if (confirm('¿Confirma que desea eliminar este Almacén?')) {
      this.formIndex = document.getElementById(
        'formIndex_' + evt.currentTarget.dataset.id,
      )
      this.formIndex.submit()
    }
    return false
  }

  onValidate(evt) {
    evt.preventDefault()

    if (document.getElementById('nombre').value.length == 0) {
      document.getElementById('nombre').className =
        'form-control border border-danger'
      document.getElementById('nombre').placeholder = '--- Valor requerido ---'
      document.getElementById('nombre').focus()
      return false
    }
    if (document.getElementById('direccion').value.length == 0) {
      document.getElementById('direccion').className =
        'form-control border border-danger'
      document.getElementById('direccion').placeholder =
        '--- Valor requerido ---'
      document.getElementById('direccion').focus()
      return false
    }

    this.form.submit()
  }
}

const almacenes = async () => {
  var Handler = new almacenesClass()
}

window.addEventListener('load', almacenes)
