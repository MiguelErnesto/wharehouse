//import Request from './modules/services/request.js'

export default class objectClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.btnPrint = document.querySelector('.btnPrint') ?? null
    this.btnVerProdAlm = document.querySelectorAll('.btnVerProdAlm')
    this.clean()
    this.addListeners()
  }

  clean() {
    if (window.location.pathname.includes('create')) {
      document.getElementById('name').value = ''
      document.getElementById('email').value = ''
      document.getElementById('password').value = ''
      document.getElementById('confirmar_password').value = ''
      document.getElementById('lbPWD').classList.add('d-none')
    }
    if (window.location.pathname.includes('edit')) {
      document.getElementById('lbPWD').classList.remove('d-none')
    }
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
    if (this.btnPrint) {
      this.btnPrint.addEventListener('click', (evt) => this.onPrint(evt))
    }
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
    /* $.ajax({
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
    }) */
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
    if (confirm('¿Confirma que desea eliminar este elemento?')) {
      this.formIndex = document.getElementById(
        'formIndex_' + evt.currentTarget.dataset.id,
      )
      this.formIndex.submit()
    }
    return false
  }

  onValidate(evt) {
    evt.preventDefault()

    if (document.getElementById('name').value.length == 0) {
      document.getElementById('name').className =
        'form-control border border-danger'
      document.getElementById('name').placeholder = '--- Valor requerido ---'
      document.getElementById('name').focus()
      return false
    }
    if (document.getElementById('email').value.length == 0) {
      document.getElementById('email').className =
        'form-control border border-danger'
      document.getElementById('email').placeholder = '--- Valor requerido ---'
      document.getElementById('email').focus()
      return false
    }
    /*valida formato de email*/
    var exp_email = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i
    if (!exp_email.test(document.getElementById('email').value)) {
      document.getElementById('email').className =
        'form-control border border-danger'
      alert('Correo electrónico no válido')
      document.getElementById('email').focus()
      return false
    }

    //Validar password para create
    if (window.location.pathname.includes('create')) {
      if (document.getElementById('password').value.length == 0) {
        document.getElementById('password').className =
          'form-control border border-danger'
        document.getElementById('password').placeholder =
          '--- Valor requerido ---'
        document.getElementById('password').focus()
        return false
      }
      if (document.getElementById('confirmar_password').value.length == 0) {
        document.getElementById('confirmar_password').className =
          'form-control border border-danger'
        document.getElementById('confirmar_password').placeholder =
          '--- Valor requerido ---'
        document.getElementById('confirmar_password').focus()
        return false
      }
      if (
        document.getElementById('password').value !=
        document.getElementById('confirmar_password').value
      ) {
        alert('Las contraseñas no coinciden')
        document.getElementById('confirmar_password').className =
          'form-control border border-danger'
        document.getElementById('confirmar_password').placeholder =
          '--- Valor requerido ---'
        document.getElementById('confirmar_password').focus()
        return false
      }
    }

    //Validar password para edit
    if (window.location.pathname.includes('edit')) {
      if (
        (document.getElementById('password').value.length != 0 ||
          document.getElementById('confirmar_password').value.length != 0) &&
        document.getElementById('password').value !=
          document.getElementById('confirmar_password').value
      ) {
        alert('Las contraseñas no coinciden')
        return false
      }
    }

    this.form.submit()
  }
}

const object = async () => {
  var Handler = new objectClass()
}

window.addEventListener('load', object)
