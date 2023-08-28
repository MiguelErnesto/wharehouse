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
    if (document.querySelector('input[name="cantidad_remitida"]')) {
      document.querySelector('input[name="cantidad_remitida"]').value = 1
    }
    if (document.querySelector('input[name="cantidad_recibida"]')) {
      document.querySelector('input[name="cantidad_recibida"]').value = 1
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
    window.open(`transferencias/imprimir/${id}`, '_blank')
  }

  onExportPDF(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    if (confirm(`¿Desea descargar esta información en un PDF?`)) {
      let id = evt.currentTarget.dataset.id
      window.open(`transferencias/exportarPDF/${id}`, '_blank')
    }
  }

  onVerDetalles(evt) {
    evt.preventDefault()
    evt.stopPropagation()

    let id = evt.currentTarget.dataset.id

    document.getElementById('informe_id').value = id

    // AJAX GET request
    $.ajax({
      url: `transferencias/getDetalles/${id}`,
      type: 'get',
      dataType: 'json',
      context: this,
      success: function (response) {
        console.log('Fetching data: SUCCESS')
        this.showDetalles(response.almacenes, response.detalles[0])
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
        <td class='text-center' colspan='3'><i>No hay elementos para mostrar...</i></td>        
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
      producto.cantidad_remitida ?? '0'
    }</td>
    <td class='text-right pr-2' style="width: 15%">${
      producto.cantidad_recibida ?? '0'
    }</td>
    </tr>`
    })
  }

  showDetalles(almacenes, informe) {
    let almacen_origen = ''
    almacenes.forEach((item) => {
      if (item.id == informe.almacen_origen_id) {
        almacen_origen = item.nombre
      }
    })

    let almacen_destino = ''
    almacenes.forEach((item) => {
      if (item.id == informe.almacen_destino_id) {
        almacen_destino = item.nombre
      }
    })

    document.getElementById('Head').innerHTML = `
  <tr>
    <td class='font-weight-bold pr-3'>
        No. Transferencia:
    </td>
    <td>
        ${informe.nro_transferencia}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class='font-weight-bold pr-3'>
        Entidad:
    </td>
    <td>
        ${informe.entidad}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class='font-weight-bold pr-3'>
        Fecha del modelo:
    </td>
    <td>
        ${informe.fecha_modelo}
    </td>
    <td></td>
    <td></td>
  </tr>
    
  <tr>
  <td class="font-weight-bold pt-3">
      Almacén origen:
  </td>
  <td class="pt-3">
      ${almacen_origen}
  </td>
  <td></td>
  <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Actualiza:
    </td>
    <td>
        ${informe.persona_actualiza_origen}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Contabiliza:
    </td>
    <td>
        ${informe.persona_contabiliza_origen}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
  <td class="font-weight-bold pt-3">
      Almacén destino:
  </td>
  <td class="pt-3">
      ${almacen_destino}
  </td>
  <td></td>
  <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Actualiza:
    </td>
    <td>
        ${informe.persona_actualiza_destino}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Contabiliza:
    </td>
    <td>
        ${informe.persona_contabiliza_destino}
    </td>
    <td></td>
    <td></td>
  </tr>
  
  <tr>
    <td class="font-weight-bold pt-3">
        Autoriza:
    </td>
    <td class="pt-3">
        ${informe.persona_autoriza}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Entrega:
    </td>
    <td>
        ${informe.persona_entrega}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Recibe:
    </td>
    <td>
        ${informe.persona_recibe}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
        Fecha de traslado:
    </td>
    <td class="pt-3">
        ${informe.fecha_traslado}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha de recepción:
    </td>
    <td>
        ${informe.fecha_recepcion}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Creado/Actualizado:
    </td>
    <td>
        ${informe.usuario}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold pt-3">
        Importe total de la entrega:
    </td>
    <td class="pt-3 pl-3">
       $ ${informe.importe_total_entrega}
    </td>
    <td class="font-weight-bold pt-3">
      Importe total recibido:
    </td>
    <td class="pt-3 pl-3">
      $ ${informe.importe_total_recibido}
    </td>
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

    const cantidad_recibida = parseInt(
      document.querySelector('input[name="cantidad_recibida"]').value,
    )
    const cantidad_remitida = parseInt(
      document.querySelector('input[name="cantidad_remitida"]').value,
    )

    this.producto = document.getElementById('producto')
    let idSelected = this.producto.value

    if (!this.productExists(idSelected)) {
      let valueSelected = document.getElementById('producto').options[
        document.getElementById('producto').selectedIndex
      ].text
      document.querySelector('table#listaProductos thead').innerHTML = `<tr>
        <th style="width: 45%">Productos agregados</th>
        <th class='text-right' style="width: 20%">Cantidad recibida</th>
        <th class='text-right' style="width: 20%">Cantidad remitida</th>
        <th></th>
     </tr>`
      document
        .querySelector('table#listaProductos tbody')
        .append(
          this.addProductoList(
            idSelected,
            valueSelected,
            cantidad_recibida,
            cantidad_remitida,
          ),
        )
    }
    this.clean()
  }

  addProductoList(id, product, cantidad_recibida, cantidad_remitida) {
    const tr = document.createElement('tr')
    tr.id = id
    tr.dataset.id = id
    tr.dataset.cantidad_recibida = cantidad_recibida
    tr.dataset.cantidad_remitida = cantidad_remitida
    tr.innerHTML = `
                    <td>${product}</td>
                    <td class="text-right">${cantidad_recibida}</td>
                    <td class="text-right">${cantidad_remitida}</td>
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

    if (document.getElementById('nro_transferencia').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('nro_transferencia').className =
        'form-control border border-danger'
      document.getElementById('nro_transferencia').placeholder =
        '--- Valor requerido ---'
      document.getElementById('nro_transferencia').focus()
      return false
    }
    if (document.getElementById('fecha_modelo').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('fecha_modelo').className =
        'form-control border border-danger'
      document.getElementById('fecha_modelo').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_modelo').focus()
      return false
    }
    if (document.getElementById('fecha_traslado').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('fecha_traslado').className =
        'form-control border border-danger'
      document.getElementById('fecha_traslado').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_traslado').focus()
      return false
    }
    if (document.getElementById('fecha_recepcion').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('fecha_recepcion').className =
        'form-control border border-danger'
      document.getElementById('fecha_recepcion').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_recepcion').focus()
      return false
    }
    if (document.getElementById('entidad').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('entidad').className =
        'form-control border border-danger'
      document.getElementById('entidad').placeholder = '--- Valor requerido ---'
      document.getElementById('entidad').focus()
      return false
    }
    if (document.getElementById('almacen_origen').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('almacen_origen').className =
        'form-control border border-danger'
      document.getElementById('almacen_origen').placeholder =
        '--- Valor requerido ---'
      document.getElementById('almacen_origen').focus()
      return false
    }
    if (document.getElementById('almacen_destino').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('almacen_destino').className =
        'form-control border border-danger'
      document.getElementById('almacen_destino').placeholder =
        '--- Valor requerido ---'
      document.getElementById('almacen_destino').focus()
      return false
    } else {
      if (
        document.getElementById('almacen_origen').value ==
        document.getElementById('almacen_destino').value
      ) {
        alert('El almacén origen y destino deben ser diferentes')
        document.getElementById('almacen_destino').className =
          'form-control border border-danger'
        document.getElementById('almacen_destino').placeholder =
          '--- Valor requerido ---'
        document.getElementById('almacen_destino').focus()
        return false
      }
    }
    if (document.getElementById('persona_actualiza_origen').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('persona_actualiza_origen').className =
        'form-control border border-danger'
      document.getElementById('persona_actualiza_origen').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_actualiza_origen').focus()
      return false
    }
    if (
      document.getElementById('persona_contabiliza_origen').value.length == 0
    ) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('persona_contabiliza_origen').className =
        'form-control border border-danger'
      document.getElementById('persona_contabiliza_origen').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_contabiliza_origen').focus()
      return false
    }
    if (
      document.getElementById('persona_actualiza_destino').value.length == 0
    ) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('persona_actualiza_destino').className =
        'form-control border border-danger'
      document.getElementById('persona_actualiza_destino').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_actualiza_destino').focus()
      return false
    }
    if (
      document.getElementById('persona_contabiliza_destino').value.length == 0
    ) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('persona_contabiliza_destino').className =
        'form-control border border-danger'
      document.getElementById('persona_contabiliza_destino').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_contabiliza_destino').focus()
      return false
    }
    if (document.getElementById('persona_autoriza').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('persona_autoriza').className =
        'form-control border border-danger'
      document.getElementById('persona_autoriza').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_autoriza').focus()
      return false
    }
    if (document.getElementById('persona_entrega').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('persona_entrega').className =
        'form-control border border-danger'
      document.getElementById('persona_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_entrega').focus()
      return false
    }
    if (document.getElementById('persona_recibe').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('persona_recibe').className =
        'form-control border border-danger'
      document.getElementById('persona_recibe').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_recibe').focus()
      return false
    }

    if (document.getElementById('importe_total_entrega').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('importe_total_entrega').className =
        'form-control border border-danger'
      document.getElementById('importe_total_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('importe_total_entrega').focus()
      return false
    }
    if (isNaN(document.getElementById('importe_total_entrega').value)) {
      alert('El valor debe ser un número')
      document.getElementById('importe_total_entrega').className =
        'form-control border border-danger'
      document.getElementById('importe_total_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('importe_total_entrega').focus()
      return false
    }

    if (document.getElementById('importe_total_recibido').value.length == 0) {
      alert('Debe completar todos los datos de la transferencia')
      document.getElementById('importe_total_recibido').className =
        'form-control border border-danger'
      document.getElementById('importe_total_recibido').placeholder =
        '--- Valor requerido ---'
      document.getElementById('importe_total_recibido').focus()
      return false
    }
    if (isNaN(document.getElementById('importe_total_recibido').value)) {
      alert('El valor debe ser un número')
      document.getElementById('importe_total_recibido').className =
        'form-control border border-danger'
      document.getElementById('importe_total_recibido').placeholder =
        '--- Valor requerido ---'
      document.getElementById('importe_total_recibido').focus()
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

      if (document.getElementById('cantidad_recibida').value.length == 0) {
        alert('Debe completar todos los datos de la transferencia')
        document.getElementById('cantidad_recibida').className =
          'form-control border border-danger'
        document.getElementById('cantidad_recibida').placeholder =
          '--- Valor requerido ---'
        document.getElementById('cantidad_recibida').focus()
        return false
      }
      if (document.getElementById('cantidad_remitida').value.length == 0) {
        alert('Debe completar todos los datos de la transferencia')
        document.getElementById('cantidad_remitida').className =
          'form-control border border-danger'
        document.getElementById('cantidad_remitida').placeholder =
          '--- Valor requerido ---'
        document.getElementById('cantidad_remitida').focus()
        return false
      }
    }

    const data = {
      _token: document.querySelector('input[name="_token"]').value,
      user_id: document.getElementById('user_id').value,
      entidad_id: document.getElementById('entidad').value,
      almacen_origen_id: document.getElementById('almacen_origen').value,
      almacen_destino_id: document.getElementById('almacen_destino').value,
      nro_transferencia: document.getElementById('nro_transferencia').value,
      fecha_modelo: document.getElementById('fecha_modelo').value,
      fecha_traslado: document.getElementById('fecha_traslado').value,
      fecha_recepcion: document.getElementById('fecha_recepcion').value,
      persona_autoriza: document.getElementById('persona_autoriza').value,
      persona_entrega: document.getElementById('persona_entrega').value,
      persona_recibe: document.getElementById('persona_recibe').value,
      persona_actualiza_origen: document.getElementById(
        'persona_actualiza_origen',
      ).value,
      persona_actualiza_destino: document.getElementById(
        'persona_actualiza_destino',
      ).value,
      persona_contabiliza_origen: document.getElementById(
        'persona_contabiliza_origen',
      ).value,
      persona_contabiliza_destino: document.getElementById(
        'persona_contabiliza_destino',
      ).value,
      importe_total_entrega: document.getElementById('importe_total_entrega')
        .value,
      importe_total_recibido: document.getElementById('importe_total_recibido')
        .value,
      productos: this.getProductos(),
    }

    if (window.location.pathname.includes('create')) {
      $.ajax({
        url: `/transferencias`,
        type: 'POST',
        dataType: 'json',
        data: data,
        context: this,
        success: function (response) {
          alert('Transferencia generada correctamente')
          window.open(`/transferencias`, '_self')
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
        cantidad_remitida: producto.dataset.cantidad_remitida,
        cantidad_recibida: producto.dataset.cantidad_recibida,
      })
    }
    return listaProductos
  }
}

const Object = async () => {
  var Handler = new ObjectClass()
}

window.addEventListener('load', Object)
