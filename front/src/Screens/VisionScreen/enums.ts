/* eslint-disable no-shadow */
export enum VisionNavigationLinks {
  clientSide = '/client-side',
  notary = '/notary',
  assistants = '/assistants',
  bank = '/bank',
  archive = '/archive',
  otherNotaryActions = '/other-notary-actions',
  clientSideRoom = '/client-side/:roomId',
  assistantInfo = '/assistants/:assistantId'
}

export enum AssistantInfoNavigationLinks {
  set = 'set',
  reading = 'reading',
  issuance = 'issuance',
  otherActions = 'other-actions',
  workSchedule = 'work-schedule',
}
