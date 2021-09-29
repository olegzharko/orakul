type VisionClientBuyer = {
  id: number;
  title: string;
}

type VisionClientImmovable = {
  id: number;
  title: string;
  step: string;
}

type VisionClientNotary = {
  id: number;
  title: string;
}

type VisionClientAccompanying = {
  id: number;
  title: string;
}

type VisionClientReader = {
  id: number;
  title: string;
}

type VisionClientRepresentative = {
  id: number;
  title: string;
  color: string;
}

export type VisionClientResponse = {
  accompanying: VisionClientAccompanying[];
  buyer: VisionClientBuyer[];
  card_id: number;
  children: boolean;
  representative_arrived: boolean;
  deal_id: number;
  immovable: VisionClientImmovable[];
  in_progress: boolean;
  notary: VisionClientNotary[];
  notary_id: number;
  number_of_people: number;
  reader: VisionClientReader[];
  representative: VisionClientRepresentative[];
  room_id: number;
  start_time: string | null;
  total_time: string | null;
  visit_time: string | null;
  waiting_time: string | null;
  color: string;
  invite_room_title: string;
};

type VisionLoadSpaceInfoRoom = {
  id: number;
  title: string;
}

type VisionLoadNotaryRoom = {
  id: number;
  title: string;
  notary_id: number;
}

export type VisionLoadSpaceInfo = {
  meeting_room: VisionClientResponse[];
  reception: VisionClientResponse[];
  rooms: {
    meeting_room: {
      [id: number]: VisionLoadSpaceInfoRoom;
    };
    notary_cabinet: {
      [id: number]: VisionLoadNotaryRoom;
    };
    reception: VisionLoadSpaceInfoRoom[];
  }
}

export type VisionRoom = {
  id: number,
  title: string,
}

export type VisionMeetingRoom = {
  id: number,
  title: string,
  client?: VisionClientResponse,
};

export type VisionNotaryRoom = {
  id: number,
  title: string,
  notary_id: number,
  client?: VisionClientResponse,
}

export type WaitingRoomGroupCardClient = {
  id: number;
  time: string,
  developer: string,
  name: string,
  color: string,
  notary_id: number,
  onCall: (roomId: number, isNotary?: boolean) => void;
}
