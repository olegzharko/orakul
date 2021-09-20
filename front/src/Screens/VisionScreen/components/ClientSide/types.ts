type VisionClientBuyer = {
  id: number;
  title: string;
}

type VisionClientImmovable = {
  id: number;
  title: string;
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
}

export type VisionClientResponse = {
  accompanying: VisionClientAccompanying[];
  buyer: VisionClientBuyer[];
  card_id: number;
  children: boolean;
  deal_id: number;
  immovable: VisionClientImmovable[];
  in_progress: boolean;
  notary: VisionClientNotary;
  notary_id: number;
  number_of_people: number;
  reader: VisionClientReader[];
  representative: VisionClientRepresentative[];
  room_id: number;
  start_time: string | null;
  total_time: string | null;
  visit_time: string | null;
  waiting_time: string | null;
};

type VisionLoadSpaceInfoRoom = {
  id: number;
  title: string;
}

export type VisionLoadSpaceInfo = {
  meeting_room: VisionClientResponse[];
  reception: VisionClientResponse[];
  rooms: {
    meeting_room: {
      [id: number]: VisionLoadSpaceInfoRoom;
    };
    notary_cabinet: {
      [id: number]: VisionLoadSpaceInfoRoom;
    };
    reception: VisionLoadSpaceInfoRoom[];
  }
}

export type VisionClient = {
  id: number,
  start_time: string,
  visit_time: string,
  waiting_time: string,
  people: number,
  children: boolean,
  in_progress: boolean,
  representative: VisionLoadSpaceInfoRoom[],
  notary: VisionLoadSpaceInfoRoom[],
  reader: VisionLoadSpaceInfoRoom[],
  accompanying: VisionLoadSpaceInfoRoom[],
  immovable: VisionLoadSpaceInfoRoom[],
  buyer: VisionLoadSpaceInfoRoom[],
};
