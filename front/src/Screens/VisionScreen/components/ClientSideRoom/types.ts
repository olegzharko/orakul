import { DefaultContentItem } from '../../../../types';

export enum ClientSideRoomTimeAliases {
  dateTime = 'date_time',
  arrivalTime = 'arrival_time',
  waitingTime = 'waiting_time',
  inviteTime = 'invite_time',
  totalTime = 'total_time',
}

export type ClientSideRoomTime = {
  title: string;
  value: string | null;
  alias: ClientSideRoomTimeAliases;
};

export type ClientSideRoomRepresentative = {
  title: string;
  value: string;
};

export type ClientSideRoomImmovable = {
  title: string;
}

export type ClientSideRoomPayment = {
  service_list: DefaultContentItem[];
  status: DefaultContentItem;
  total_price: DefaultContentItem;
}

export type ClientSideRoomStage = {
  title: string;
  step: {
    id: number;
    status: boolean;
    time: string;
    title: string;
  }[];
};

export type ClientSideRoomOther = {
  title: string;
  info: {id: string, title: string}[];
}
