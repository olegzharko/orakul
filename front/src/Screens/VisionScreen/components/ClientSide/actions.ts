import getSpaceInfo from '../../../../services/vision/getSpaceInfo';
import { formatRooms } from './utils';

export const loadSpaceInfo = async (token: string) => {
  const res = await getSpaceInfo(token);

  if (res.success) {
    const { reception, meeting_room, notary_cabinet, rooms } = res.data;
    const meetingRooms = formatRooms(meeting_room, Object.values(rooms.meeting_room));
    const notaryRooms = formatRooms(notary_cabinet, Object.values(rooms.notary_cabinet));
    return [reception, meetingRooms, notaryRooms];
  }

  return [];
};
