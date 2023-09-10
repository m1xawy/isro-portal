import { DateTime } from 'luxon'

it('can handle UTC datetime', () => {
  expect(
    DateTime.fromISO('2021-10-14T02:48:15+00:00')
      .setZone('UTC')
      .toISO()
  ).toEqual('2021-10-14T02:48:15.000Z')
})

it('can convert datetime from UTC', () => {
  expect(
    DateTime.fromISO('2021-10-14T02:48:15+00:00')
      .setZone('America/Chicago')
      .toISO()
  ).toEqual('2021-10-13T21:48:15.000-05:00')
  expect(
    DateTime.fromISO('2021-10-14T02:48:15+00:00')
      .setZone('America/Mexico_City')
      .toISO()
  ).toEqual('2021-10-13T21:48:15.000-05:00')
  expect(
    DateTime.fromISO('2023-05-02T14:00:00+00:00')
      .setZone('America/Mexico_City')
      .toISO()
  ).toEqual('2023-05-02T08:00:00.000-06:00')
  expect(
    DateTime.fromISO('2021-10-14T02:48:15+00:00')
      .setZone('Europe/Paris')
      .toISO()
  ).toEqual('2021-10-14T04:48:15.000+02:00')
  expect(
    DateTime.fromISO('2022-05-10T10:00:00+00:00')
      .setZone('Europe/Paris')
      .toISO()
  ).toEqual('2022-05-10T12:00:00.000+02:00')
  expect(
    DateTime.fromISO('2021-10-14T02:48:15+00:00')
      .setZone('Asia/Kuala_Lumpur')
      .toISO()
  ).toEqual('2021-10-14T10:48:15.000+08:00')
})

it('can convert datetime to UTC', () => {
  expect(
    DateTime.fromISO('2021-10-13T21:48:15.000-05:00', { zone: 'America/Chicago' })
      .setZone('UTC')
      .toISO()
  ).toEqual('2021-10-14T02:48:15.000Z')
  expect(
    DateTime.fromISO('2021-10-13T21:48:15.000-05:00', { zone: 'America/Mexico_City' })
      .setZone('UTC')
      .toISO()
  ).toEqual('2021-10-14T02:48:15.000Z')
  expect(
    DateTime.fromISO('2023-05-02T08:00:00.000-06:00', { zone: 'America/Mexico_City' })
      .setZone('UTC')
      .toISO()
  ).toEqual('2023-05-02T14:00:00.000Z')
  expect(
    DateTime.fromISO('2021-10-14T04:48:15.000+02:00', { zone: 'Europe/Paris' })
      .setZone('UTC')
      .toISO()
  ).toEqual('2021-10-14T02:48:15.000Z')
  expect(
    DateTime.fromISO('2022-05-10T12:00:00.000+02:00', { zone: 'Europe/Paris' })
      .setZone('UTC')
      .toISO()
  ).toEqual('2022-05-10T10:00:00.000Z')
  expect(
    DateTime.fromISO('2021-10-14T10:48:15.000+08:00', { zone: 'Asia/Kuala_Lumpur' })
      .setZone('UTC')
      .toISO()
  ).toEqual('2021-10-14T02:48:15.000Z')
})
