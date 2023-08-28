export default class ObjectClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.add = document.getElementById('add')

    this.btnVerDetalles = document.querySelectorAll('.btnVerDetalles')

    this.btnPrint = document.querySelectorAll('.btnPrint')
    this.btnPDFExport = document.querySelectorAll('.btnPDFExport')
    this.tipoSalida = document.getElementById('tipo_salida')
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
    if (document.querySelector('input[name="cantidad_ordenada"]')) {
      document.querySelector('input[name="cantidad_ordenada"]').value = 1
    }
    if (document.querySelector('input[name="cantidad_despachada"]')) {
      document.querySelector('input[name="cantidad_despachada"]').value = 1
    }
    if (document.querySelector('input[name="cantidad_entregada"]')) {
      document.querySelector('input[name="cantidad_entregada"]').value = 1
    }
    if (document.querySelector('producto')) {
      document.getElementById('producto').value = ''
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

    this.tipoSalida.addEventListener('change', (evt) =>
      this.onChandeTipoSalida(evt),
    )

    $(document).ready(function () {
      console.log('Ready!')
    })
  }

  onChandeTipoSalida(evt) {
    if (this.tipoSalida.value == 'V') {
      document.getElementById('divVale').classList.remove('d-none')
      document.getElementById('transferencia').value = ''
      document.getElementById('divTransferencia').classList.add('d-none')
    }
    if (this.tipoSalida.value == 'T') {
      document.getElementById('divTransferencia').classList.remove('d-none')
      document.getElementById('vale').value = ''
      document.getElementById('divVale').classList.add('d-none')
    }
  }

  onPrint(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    let id = evt.currentTarget.dataset.id
    window.open(`ordenes_despacho/imprimir/${id}`, '_blank')
  }

  onExportPDF(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    if (confirm(`¿Desea descargar esta información en un PDF?`)) {
      let id = evt.currentTarget.dataset.id
      window.open(`ordenes_despacho/exportarPDF/${id}`, '_blank')
    }
  }

  onVerDetalles(evt) {
    evt.preventDefault()
    evt.stopPropagation()

    let id = evt.currentTarget.dataset.id

    document.getElementById('informe_id').value = id

    // AJAX GET request
    $.ajax({
      url: `ordenes_despacho/getDetalles/${id}`,
      type: 'get',
      dataType: 'json',
      context: this,
      success: function (response) {
        console.log('Fetching data: SUCCESS')
        this.showDetalles(
          response.detalles[0],
          response.vales,
          response.transferencias,
        )
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
        <td class='text-center' colspan='4'><i>No hay elementos para mostrar...</i></td>        
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
      producto.cantidad_ordenada ?? '0'
    }</td>
    <td class='text-right pr-2' style="width: 15%">${
      producto.cantidad_despachada ?? '0'
    }</td>
    <td class='text-right pr-2' style="width: 15%">${
      producto.cantidad_entregada ?? '0'
    }</td>
    </tr>`
    })
  }

  showDetalles(informe, vales, transferencias) {
    let salida1 = `<tr>
    <td class="font-weight-bold pr-3">
        No. Orden:
    </td>
    <td>
        ${informe.nro_orden}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha:
    </td>
    <td>
        ${informe.fecha}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Salida por:
    </td>
    <td>`

    let salida2 = ''
    vales.forEach((vale) => {
      if (vale.id == informe.vale_id) {
        salida2 = 'VALE  (Nro: ' + vale.nro_vale + ')'
      }
    })
    transferencias.forEach((transferencia) => {
      if (transferencia.id == informe.transferencia_id) {
        salida2 =
          'TRANSFERENCIA  (Nro: ' + transferencia.nro_transferencia + ')'
      }
    })

    let salida3 = `</td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
        Entidad:
    </td>
    <td class="pt-3">
        ${informe.entidad}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Almacén:
    </td>
    <td>
        ${informe.almacen}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Cliente:
    </td>
    <td>
        ${informe.cliente}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
        Lugar de entrega:
    </td>
    <td class="pt-3">
        ${informe.lugar_entrega}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha de entrega:
    </td>
    <td>
        ${informe.fecha_entrega}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td  class="font-weight-bold pt-3">
        Creado/Actualizado:
    </td>
    <td  class="pt-3">
        ${informe.usuario}
    </td>
    <td></td>
    <td></td>
  </tr>
  <br/>`

    document.getElementById('Head').innerHTML = salida1 + salida2 + salida3
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

    const cantidad_ordenada = parseInt(
      document.querySelector('input[name="cantidad_ordenada"]').value,
    )

    const cantidad_despachada = parseInt(
      document.querySelector('input[name="cantidad_despachada"]').value,
    )

    const cantidad_entregada = parseInt(
      document.querySelector('input[name="cantidad_entregada"]').value,
    )

    this.producto = document.getElementById('producto')
    let idSelected = this.producto.value

    if (!this.productExists(idSelected)) {
      let valueSelected = document.getElementById('producto').options[
        document.getElementById('producto').selectedIndex
      ].text
      document.querySelector('table#listaProductos thead').innerHTML = `<tr>
        <th style="width: 55%">Productos agregados</th>
        <th class='text-right' style="width: 15%">Cantidad ordenada</th>
        <th class='text-right' style="width: 15%">Cantidad despachada</th>
        <th class='text-right' style="width: 15%">Cantidad entregada</th>
        <th></th>
     </tr>`
      document
        .querySelector('table#listaProductos tbody')
        .append(
          this.addProductoList(
            idSelected,
            valueSelected,
            cantidad_ordenada,
            cantidad_despachada,
            cantidad_entregada,
          ),
        )
    }
    this.clean()
  }

  addProductoList(
    id,
    product,
    cantidad_ordenada,
    cantidad_despachada,
    cantidad_entregada,
  ) {
    const tr = document.createElement('tr')
    tr.id = id
    tr.dataset.id = id
    tr.dataset.cantidad_ordenada = cantidad_ordenada
    tr.dataset.cantidad_despachada = cantidad_despachada
    tr.dataset.cantidad_entregada = cantidad_entregada
    tr.innerHTML = `
                    <td>${product}</td>
                    <td class="text-right">${cantidad_ordenada}</td>
                    <td class="text-right">${cantidad_despachada}</td>
                    <td class="text-right">${cantidad_entregada}</td>
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

    if (document.getElementById('fecha').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('fecha').className =
        'form-control border border-danger'
      document.getElementById('fecha').placeholder = '--- Valor requerido ---'
      document.getElementById('fecha').focus()
      return false
    }
    if (document.getElementById('nro_orden').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('nro_orden').className =
        'form-control border border-danger'
      document.getElementById('nro_orden').placeholder =
        '--- Valor requerido ---'
      document.getElementById('nro_orden').focus()
      return false
    }
    if (document.getElementById('entidad').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('entidad').className =
        'form-control border border-danger'
      document.getElementById('entidad').placeholder = '--- Valor requerido ---'
      document.getElementById('entidad').focus()
      return false
    }
    if (document.getElementById('almacen').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('almacen').className =
        'form-control border border-danger'
      document.getElementById('almacen').placeholder = '--- Valor requerido ---'
      document.getElementById('almacen').focus()
      return false
    }
    if (document.getElementById('cliente').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('cliente').className =
        'form-control border border-danger'
      document.getElementById('cliente').placeholder = '--- Valor requerido ---'
      document.getElementById('cliente').focus()
      return false
    }
    if (document.getElementById('lugar_entrega').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('lugar_entrega').className =
        'form-control border border-danger'
      document.getElementById('lugar_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('lugar_entrega').focus()
      return false
    }
    if (document.getElementById('fecha_entrega').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('fecha_entrega').className =
        'form-control border border-danger'
      document.getElementById('fecha_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_entrega').focus()
      return false
    }
    if (document.getElementById('tipo_salida').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('tipo_salida').className =
        'form-control border border-danger'
      document.getElementById('tipo_salida').placeholder =
        '--- Valor requerido ---'
      document.getElementById('tipo_salida').focus()
      return false
    }
    if (document.getElementById('tipo_salida').value == 'V') {
      if (document.getElementById('vale').value.length == 0) {
        alert('Debe completar todos los datos de la Orden')
        document.getElementById('vale').className =
          'form-control border border-danger'
        document.getElementById('vale').placeholder = '--- Valor requerido ---'
        document.getElementById('vale').focus()
        return false
      }
    }
    if (document.getElementById('tipo_salida').value == 'T') {
      if (document.getElementById('transferencia').value.length == 0) {
        alert('Debe completar todos los datos de la Orden')
        document.getElementById('transferencia').className =
          'form-control border border-danger'
        document.getElementById('transferencia').placeholder =
          '--- Valor requerido ---'
        document.getElementById('transferencia').focus()
        return false
      }
    }
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

    if (document.getElementById('cantidad_ordenada').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('cantidad_ordenada').className =
        'form-control border border-danger'
      document.getElementById('cantidad_ordenada').placeholder =
        '--- Valor requerido ---'
      document.getElementById('cantidad_ordenada').focus()
      return false
    }

    if (document.getElementById('cantidad_despachada').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('cantidad_despachada').className =
        'form-control border border-danger'
      document.getElementById('cantidad_despachada').placeholder =
        '--- Valor requerido ---'
      document.getElementById('cantidad_despachada').focus()
      return false
    }

    if (document.getElementById('cantidad_entregada').value.length == 0) {
      alert('Debe completar todos los datos de la Orden')
      document.getElementById('cantidad_entregada').className =
        'form-control border border-danger'
      document.getElementById('cantidad_entregada').placeholder =
        '--- Valor requerido ---'
      document.getElementById('cantidad_entregada').focus()
      return false
    }

    const data = {
      _token: document.querySelector('input[name="_token"]').value,
      user_id: document.getElementById('user_id').value,
      fecha: document.getElementById('fecha').value,
      nro_orden: document.getElementById('nro_orden').value,
      entidad_id: document.getElementById('entidad').value,
      almacen_id: document.getElementById('almacen').value,
      cliente_id: document.getElementById('cliente').value,
      lugar_entrega: document.getElementById('lugar_entrega').value,
      fecha_entrega: document.getElementById('fecha_entrega').value,
      vale_id:
        document.getElementById('vale').value.length == 0
          ? null
          : document.getElementById('vale').value,
      transferencia_id:
        document.getElementById('transferencia').value.length == 0
          ? null
          : document.getElementById('transferencia').value,
      productos: this.getProductos(),
    }

    $.ajax({
      url: `/ordenes_despacho`,
      type: 'POST',
      dataType: 'json',
      data: data,
      context: this,
      success: function (response) {
        alert('Orden de despacho exitosa')
        window.open(`/ordenes_despacho`, '_self')
      },
      error: function (error) {
        console.log('Fetching data: ERROR')
        console.log(JSON.stringify(error))
      },
    })
  }

  getProductos() {
    let NodelistaProductos = document.querySelectorAll(
      'table#listaProductos tbody tr',
    )
    const listaProductos = []
    for (const producto of NodelistaProductos) {
      listaProductos.unshift({
        id: producto.dataset.id,
        cantidad_ordenada: producto.dataset.cantidad_ordenada,
        cantidad_despachada: producto.dataset.cantidad_despachada,
        cantidad_entregada: producto.dataset.cantidad_entregada,
      })
    }
    return listaProductos
  }
}

const Object = async () => {
  var Handler = new ObjectClass()
}

window.addEventListener('load', Object)
