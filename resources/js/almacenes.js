//import Request from './modules/services/request.js'

export default class almacenesClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.btnPrint = document.querySelector('.btnPrint') ?? null
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
    this.btnPrint.addEventListener('click', (evt) => this.onPrint(evt))

    $(document).ready(function () {
      console.log('Ready!')
    })
  }

  onPrint(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    let id = document.getElementById('almacen_id').value
    window.open(`almacenes_productos/imprimir/${id}`, '_blank')

    // AJAX GET request
    $.ajax({
      url: `almacenes_productos/imprimir/${id}`,
      type: 'get',
      dataType: 'json',
      context: this,
      success: function (response) {
        alert(JSON.stringify(response))
      },
      error: function (error) {
        console.log('Fetching data: ERROR')
        console.log(JSON.stringify(error))
      },
    })
  }

  onVerProductosAlmacen(evt) {
    evt.preventDefault()
    evt.stopPropagation()

    let id = evt.currentTarget.dataset.id
    let nombre = evt.currentTarget.dataset.nombre
    let direccion = evt.currentTarget.dataset.direccion

    document.getElementById('almacen_id').value = id

    // AJAX GET request
    $.ajax({
      url: `almacenes_productos/getProductosAlmacen/${id}`,
      type: 'get',
      dataType: 'json',
      context: this,
      success: function (response) {
        console.log('Fetching data: SUCCESS')
        this.showDataAlmacen(nombre, direccion)
        this.showProductosAlmacen(response)
      },
      error: function (error) {
        console.log('Fetching data: ERROR')
        console.log(JSON.stringify(error))
      },
    })
  }

  showProductosAlmacen(response) {
    const listaProductos = document.querySelector(
      '#listaProductosAlmacen tbody',
    )
    listaProductos.innerHTML = ''

    if (!response.length > 0) {
      listaProductos.innerHTML = `
      <tr>
        <td class='text-center' colspan='4'><i>No hay elementos para mostrar...</i></td>        
      </tr>`
      return false
    }

    response.forEach((producto) => {
      listaProductos.innerHTML += `
      <tr>
    <td style="width: 15%">${producto.pCodigo}</td>
    <td style="width: 30%">${producto.pNombre}</td>
    <td style="width: 40%">${producto.pDescripcion}</td>
    <td class='text-right pr-2' style="width: 15%">${
      producto.apCantidad ?? '0'
    }</td>
    </tr>`
    })
  }

  showDataAlmacen(nombre, direccion) {
    document.getElementById('Head').innerHTML = `<tr>
    <td class="font-weight-bold pr-3">
        Almacén:
    </td>
    <td>
        ${nombre}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Dirección:
    </td>
    <td>
        ${direccion}
    </td>
    <td></td>
    <td></td>
  </tr>
  <br/>`
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
