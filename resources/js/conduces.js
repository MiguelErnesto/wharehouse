export default class ObjectClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.add = document.getElementById('add')

    this.btnVerDetalles = document.querySelectorAll('.btnVerDetalles')

    this.btnPrint = document.querySelectorAll('.btnPrint')
    this.btnPDFExport = document.querySelectorAll('.btnPDFExport')
    this.addListeners()
    this.clean()
  }

  clean() {
    if (document.querySelector('table#listaProductos tbody')) {
      if (
        document.querySelector('table#listaProductos tbody').innerHTML == ''
      ) {
        document.querySelector('table#listaProductos thead').innerHTML = ''
      }
    }
    if (document.querySelector('input[name="cantidad"]')) {
      document.querySelector('input[name="cantidad"]').value = 1
    }
    if (document.querySelector('producto')) {
      document.getElementById('producto').value = ''
    }
    if (window.location.pathname.includes('edit')) {
      document.getElementById('divProductos').classList.add('d-none')
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

    if (this.add) {
      this.add.addEventListener('click', () => this.onAddProducts())
    }

    if (this.btnVerDetalles) {
      for (var i = 0; i < this.btnVerDetalles.length; i += 1) {
        this.btnVerDetalles[i].addEventListener('click', (evt) =>
          this.onVerDetalles(evt),
        )
      }
    }

    if (this.btnPrint) {
      for (var i = 0; i < this.btnPrint.length; i += 1) {
        this.btnPrint[i].addEventListener('click', (evt) => this.onPrint(evt))
      }
    }

    if (this.btnPDFExport) {
      for (var i = 0; i < this.btnPDFExport.length; i += 1) {
        this.btnPDFExport[i].addEventListener('click', (evt) =>
          this.onExportPDF(evt),
        )
      }
    }

    $(document).ready(function () {
      console.log('Ready!')
    })
  }

  onPrint(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    let id = evt.currentTarget.dataset.id
    window.open(`conduces/imprimir/${id}`, '_blank')
  }

  onExportPDF(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    if (confirm(`¿Desea descargar esta información en un PDF?`)) {
      let id = evt.currentTarget.dataset.id
      window.open(`conduces/exportarPDF/${id}`, '_blank')
    }
  }

  onVerDetalles(evt) {
    evt.preventDefault()
    evt.stopPropagation()

    let id = evt.currentTarget.dataset.id

    document.getElementById('informe_id').value = id

    // AJAX GET request
    $.ajax({
      url: `conduces/getDetalles/${id}`,
      type: 'get',
      dataType: 'json',
      context: this,
      success: function (response) {
        console.log('Fetching data: SUCCESS')
        this.showDetalles(response.detalles[0])
        this.showProductos(response.productos)
      },
      error: function (error) {
        console.log('Fetching data: ERROR')
        console.log(JSON.stringify(error))
      },
    })
  }

  showProductos(productos) {
    const listaProductos = document.querySelector(
      '#listaProductosInforme tbody',
    )
    listaProductos.innerHTML = ''

    if (!productos.length > 0) {
      listaProductos.innerHTML = `
      <tr>
        <td class='text-center' colspan='2'><i>No hay elementos para mostrar...</i></td>        
      </tr>`
      return false
    }

    productos.forEach((producto) => {
      listaProductos.innerHTML += `
      <tr>
    <td style="width: 15%">${producto.codigo}</td>
    <td style="width: 30%">${producto.nombre}</td>
    <td style="width: 40%">${producto.descripcion}</td>
    <td class='text-right pr-2' style="width: 15%">${
      producto.cantidad ?? '0'
    }</td>
    </tr>`
    })
  }

  showDetalles(informe) {
    document.getElementById('Head').innerHTML = `
  <tr>
    <td class='font-weight-bold pr-3'>
        No. Conduce:
    </td>
    <td>
        ${informe.nro_conduce}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Entidad:
    </td>
    <td>
      ${informe.entidad}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha del modelo:
    </td>
    <td class="">
        ${informe.fecha_modelo}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
  <td class="font-weight-bold">
      Factura asociada:
  </td>
  <td class="">
      ${informe.nro_factura}
  </td>
  <td></td>
  <td></td>
</tr>

<tr>
    <td class="font-weight-bold pt-3">
        Comprador:
    </td>
    <td class="pt-3">
        ${informe.comprador}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Lugar de entrega:
    </td>
    <td>
        ${informe.lugar_entrega}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
        Transportador:
    </td>
    <td class="pt-3">
        ${informe.transportador}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha que recibe:
    </td>
    <td>
        ${informe.fecha_recepcion_transportador}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
        Entrega:
    </td>
    <td class="pt-3">
        ${informe.persona_entrega}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha que entrega:
    </td>
    <td>
        ${informe.fecha_entrega}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
        Recibe:
    </td>
    <td class="pt-3">
        ${informe.persona_recepcion}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha que recibe:
    </td>
    <td>
        ${informe.fecha_recepcion}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
        Actualiza:
    </td>
    <td class="pt-3">
        ${informe.persona_actualiza}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Contabiliza:
    </td>
    <td>
        ${informe.persona_contabiliza}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
    Creado/Actualizado:
    </td>
    <td class="pt-3">
        ${informe.usuario}
    </td>
    <td></td>
    <td></td>
  </tr>
  <br/>`
  }

  formated_datetime(fecha) {
    // Mostrar Fecha del movimiento en formato ('dd/mm/yy')
    let inputDate = new Date(fecha)
    let date = inputDate.getDate()
    let month = inputDate.getMonth() + 1
    let year = inputDate.getFullYear()
    date = date.toString().padStart(2, '0')
    month = month.toString().padStart(2, '0')
    const fecha_formato = date + '-' + month + '-' + year

    return fecha_formato + ' ' + inputDate.toLocaleTimeString()
  }

  onAddProducts() {
    if (document.getElementById('producto').value.length == 0) {
      alert('Debe seleccionar un producto')
      document.getElementById('producto').className =
        'form-control border border-danger'
      document.getElementById('producto').placeholder =
        '--- Valor requerido ---'
      document.getElementById('producto').focus()
      return false
    }

    const cantidad = parseInt(
      document.querySelector('input[name="cantidad"]').value,
    )

    this.producto = document.getElementById('producto')
    let idSelected = this.producto.value

    if (!this.productExists(idSelected)) {
      let valueSelected = document.getElementById('producto').options[
        document.getElementById('producto').selectedIndex
      ].text
      document.querySelector('table#listaProductos thead').innerHTML = `<tr>
        <th style="width: 55%">Productos agregados</th>
        <th class='text-right' style="width: 15%">Cantidad</th>
        <th></th>
     </tr>`
      document
        .querySelector('table#listaProductos tbody')
        .append(this.addProductoList(idSelected, valueSelected, cantidad))
    }
    this.clean()
  }

  addProductoList(id, product, cantidad) {
    const tr = document.createElement('tr')
    tr.id = id
    tr.dataset.id = id
    tr.dataset.cantidad = cantidad
    tr.innerHTML = `
                    <td>${product}</td>
                    <td class="text-right">${cantidad}</td>
                    <td class="text-center pl-5 pr-3"><a href="#" class="btn btn-sm btn-danger deleteProductoFromList"> <i class="fas fa-solid fa-trash fa-lg"></i></a></td>
                `
    tr.querySelector('.deleteProductoFromList').addEventListener(
      'click',
      (evt) => {
        if (confirm('¿Desea eliminar el producto de la lista?')) {
          document
            .querySelector(`table#listaProductos tbody tr[id="${id}"]`)
            .remove()
        }
      },
    )

    return tr
  }

  productExists(id) {
    const productsWithId = document.querySelectorAll(
      `table#listaProductos tbody tr[id="${id}"]`,
    )
    if (productsWithId.length > 0) {
      alert('El producto ya fué agregado al listado')
      return true
    }
    return false
  }

  onDelete(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    if (confirm(`¿Confirma que desea eliminar este elemento?`)) {
      this.formIndex = document.getElementById(
        'formIndex_' + evt.currentTarget.dataset.id,
      )
      this.formIndex.submit()
    }
    return false
  }

  onValidate(evt) {
    evt.preventDefault()
    evt.stopPropagation()

    if (document.getElementById('fecha_modelo').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('fecha_modelo').className =
        'form-control border border-danger'
      document.getElementById('fecha_modelo').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_modelo').focus()
      return false
    }
    if (document.getElementById('nro_conduce').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('nro_conduce').className =
        'form-control border border-danger'
      document.getElementById('nro_conduce').placeholder =
        '--- Valor requerido ---'
      document.getElementById('nro_conduce').focus()
      return false
    }
    if (document.getElementById('nro_factura').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('nro_factura').className =
        'form-control border border-danger'
      document.getElementById('nro_factura').placeholder =
        '--- Valor requerido ---'
      document.getElementById('nro_factura').focus()
      return false
    }
    if (document.getElementById('entidad').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('entidad').className =
        'form-control border border-danger'
      document.getElementById('entidad').placeholder = '--- Valor requerido ---'
      document.getElementById('entidad').focus()
      return false
    }
    if (document.getElementById('comprador').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('comprador').className =
        'form-control border border-danger'
      document.getElementById('comprador').placeholder =
        '--- Valor requerido ---'
      document.getElementById('comprador').focus()
      return false
    }
    if (document.getElementById('lugar_entrega').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('lugar_entrega').className =
        'form-control border border-danger'
      document.getElementById('lugar_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('lugar_entrega').focus()
      return false
    }
    if (document.getElementById('transportador').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('transportador').className =
        'form-control border border-danger'
      document.getElementById('transportador').placeholder =
        '--- Valor requerido ---'
      document.getElementById('transportador').focus()
      return false
    }
    if (
      document.getElementById('fecha_recepcion_transportador').value.length == 0
    ) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('fecha_recepcion_transportador').className =
        'form-control border border-danger'
      document.getElementById('fecha_recepcion_transportador').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_recepcion_transportador').focus()
      return false
    }
    if (document.getElementById('persona_entrega').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('persona_entrega').className =
        'form-control border border-danger'
      document.getElementById('persona_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_entrega').focus()
      return false
    }
    if (document.getElementById('fecha_entrega').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('fecha_entrega').className =
        'form-control border border-danger'
      document.getElementById('fecha_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_entrega').focus()
      return false
    }
    if (document.getElementById('persona_recepcion').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('persona_recepcion').className =
        'form-control border border-danger'
      document.getElementById('persona_recepcion').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_recepcion').focus()
      return false
    }
    if (document.getElementById('fecha_recepcion').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('fecha_recepcion').className =
        'form-control border border-danger'
      document.getElementById('fecha_recepcion').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_recepcion').focus()
      return false
    }
    if (document.getElementById('persona_actualiza').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('persona_actualiza').className =
        'form-control border border-danger'
      document.getElementById('persona_actualiza').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_actualiza').focus()
      return false
    }
    if (document.getElementById('persona_contabiliza').value.length == 0) {
      alert('Debe completar todos los datos del Conduce')
      document.getElementById('persona_contabiliza').className =
        'form-control border border-danger'
      document.getElementById('persona_contabiliza').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_contabiliza').focus()
      return false
    }

    if (window.location.pathname.includes('create')) {
      if (
        document.querySelectorAll('table#listaProductos tbody tr').length == 0
      ) {
        alert('Debe agregar al menos un producto')
        document.getElementById('producto').className =
          'form-control border border-danger'
        document.getElementById('producto').placeholder =
          '--- Valor requerido ---'
        document.getElementById('producto').focus()
        return false
      }

      if (document.getElementById('cantidad').value.length == 0) {
        alert('Debe completar todos los datos del Conduce')
        document.getElementById('cantidad').className =
          'form-control border border-danger'
        document.getElementById('cantidad').placeholder =
          '--- Valor requerido ---'
        document.getElementById('cantidad').focus()
        return false
      }
    }

    const data = {
      _token: document.querySelector('input[name="_token"]').value,
      user_id: document.getElementById('user_id').value,
      fecha_modelo: document.getElementById('fecha_modelo').value,
      nro_conduce: document.getElementById('nro_conduce').value,
      nro_factura: document.getElementById('nro_factura').value,
      entidad_id: document.getElementById('entidad').value,
      comprador: document.getElementById('comprador').value,
      lugar_entrega: document.getElementById('lugar_entrega').value,
      transportador: document.getElementById('transportador').value,
      fecha_recepcion_transportador: document.getElementById(
        'fecha_recepcion_transportador',
      ).value,
      persona_entrega: document.getElementById('persona_entrega').value,
      fecha_entrega: document.getElementById('fecha_entrega').value,
      persona_recepcion: document.getElementById('persona_recepcion').value,
      fecha_recepcion: document.getElementById('fecha_recepcion').value,
      persona_actualiza: document.getElementById('persona_actualiza').value,
      persona_contabiliza: document.getElementById('persona_contabiliza').value,
      productos: this.getProductos(),
    }

    if (window.location.pathname.includes('create')) {
      $.ajax({
        url: `/conduces`,
        type: 'POST',
        dataType: 'json',
        data: data,
        context: this,
        success: function (response) {
          alert('Conduce generado correctamente')
          window.open(`/conduces`, '_self')
        },
        error: function (error) {
          console.log('Fetching data: ERROR')
          console.log(JSON.stringify(error))
          alert(JSON.stringify(error))
        },
      })
    } else {
      this.form.submit()
    }
  }

  getProductos() {
    let NodelistaProductos = document.querySelectorAll(
      'table#listaProductos tbody tr',
    )
    const listaProductos = []
    for (const producto of NodelistaProductos) {
      listaProductos.unshift({
        id: producto.dataset.id,
        cantidad: producto.dataset.cantidad,
      })
    }
    return listaProductos
  }
}

const Object = async () => {
  var Handler = new ObjectClass()
}

window.addEventListener('load', Object)
