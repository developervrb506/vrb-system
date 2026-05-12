# Prompt para Claude - VRB Agent Payment Control

Necesito crear en el sistema VRB un nuevo módulo llamado **Agent Payment Control** para controlar balances de agentes, llamadas de clerks y pagos.

## Contexto funcional
Tenemos una lista de agentes importada desde un Excel con columnas:
- AGENT
- BALANCE
- NAME
- NOTES

La lista será trabajada principalmente por dos clerks: Wendy y Tanisha, pero el sistema debe usar el `clerk_id` del usuario logueado, no valores hardcodeados.

## Objetivo principal de la pantalla
Crear una página fácil de leer donde se vea claramente:
- Agent code
- Agent name
- Current balance visible
- Status: active / inactive
- Clerk assigned / person in charge
- Last call date
- Last clerk who called
- Last note
- Quick action buttons

La página debe permitir filtrar por:
- Active / inactive
- Assigned clerk
- Balance greater than 0
- Search by agent code or name

## Base de datos
Usar únicamente tablas con prefijo `c_` para evitar choques con tablas existentes.
El script SQL base está en `agent_payment_control.sql` e incluye estas tablas:
- `c_agents`
- `c_agent_assignments`
- `c_agent_call_notes`
- `c_agent_payments`
- `c_agent_balance_movements`

No crear tablas sin prefijo `c_`.
No modificar tablas existentes de VRB salvo que sea estrictamente necesario.
Los campos `clerk_id` deben guardar el ID del usuario logueado actual del sistema.

## Flujo 1: asignación de agente
Desde la lista principal debe poder asignarse un agente a un clerk.
Cuando se asigne:
1. Actualizar `c_agents.assigned_clerk_id`.
2. Insertar registro en `c_agent_assignments`.
3. Si ya existía una asignación activa anterior, cerrarla con `released_at`.

## Flujo 2: notas / llamadas
Desde cada agente debe existir un popup o panel lateral para agregar nota de llamada.
Al guardar nota:
1. Insertar en `c_agent_call_notes`.
2. Guardar `agent_id`, `clerk_id`, `call_status`, `note_text`, `created_at`.
3. Actualizar en `c_agents`:
   - `last_call_at = NOW()`
   - `last_call_clerk_id = clerk_id logueado`

El historial debe mostrarse en orden descendente, la nota más reciente arriba.

## Flujo 3: incremento / decremento manual de balance
Desde un popup del agente debe poder agregarse:
- Incremento de balance
- Decremento de balance

Campos:
- amount
- detail/comment
- clerk_id logueado
- fecha automática

Regla:
- Incremento aumenta `c_agents.current_balance`.
- Decremento reduce `c_agents.current_balance`.
- Todo cambio debe insertar un registro en `c_agent_balance_movements`.
- Hacer el update de balance y el insert del movimiento dentro de una transacción SQL.
- Guardar `balance_before` y `balance_after`.

## Flujo 4: pagos de agentes
El clerk puede registrar un pago con estado inicial `pending`.
Campos del pago:
- agent_id
- amount
- deposit_reference_id
- method
- comment
- created_by_clerk_id
- status = pending

Mientras el pago esté pending, NO debe afectar el balance.

Cuando un pago se marque como `completed`:
1. Validar que el pago esté en `pending`.
2. Bloquear el agente con `SELECT ... FOR UPDATE`.
3. Restar el monto del balance del agente.
4. Actualizar el pago a `completed`.
5. Guardar `completed_by_clerk_id` y `completed_at`.
6. Insertar movimiento en `c_agent_balance_movements` con:
   - movement_type = `payment_completed`
   - direction = `debit`
   - payment_id
   - amount
   - balance_before
   - balance_after
   - clerk_id

Todo debe hacerse en una transacción.

## Popup de agente
El popup o drawer de cada agente debe mostrar tabs/secciones:
1. Summary
   - agent code
   - name
   - current balance
   - status
   - assigned clerk
   - last call
2. Notes
   - historial de notas
   - formulario para nueva nota
3. Balance Movements
   - incrementos/decrementos/pagos completados
   - fecha, tipo, monto, before, after, clerk, detail
4. Payments
   - pagos pending/completed/cancelled
   - formulario para registrar pago
   - botón para marcar pending como completed

## Reglas visuales importantes
La prioridad es que la lista sea muy visual y fácil de leer:
- Balance grande y claro.
- Colores por estado:
  - active normal
  - inactive gris
  - balance alto resaltado
  - pending payments en amarillo/naranja
- Mostrar badges para assigned clerk y status.
- Mostrar last call date visible.
- Mostrar último comentario resumido en la tabla principal.

## Seguridad / permisos
- Usar el sistema actual de login de VRB.
- Tomar el `clerk_id` desde la sesión actual.
- No permitir registrar movimientos sin usuario logueado.
- Validar amounts positivos.
- Validar que deposit_reference_id no se repita.
- No hacer cambios destructivos sin confirmación.

## Entregables esperados
1. Crear el SQL/migration usando `agent_payment_control.sql` como base.
2. Crear la página principal del módulo.
3. Crear endpoints/controladores necesarios.
4. Crear popup/drawer para detalle del agente.
5. Implementar notas, movimientos manuales y pagos.
6. Usar transacciones para cualquier cambio que afecte balance.
7. Mantener el código simple, claro y compatible con el estilo actual del proyecto VRB.
