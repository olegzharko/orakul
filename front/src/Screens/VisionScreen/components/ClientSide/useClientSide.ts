import { useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';

import { State } from '../../../../store/types';

import { loadSpaceInfo } from './actions';
import { VisionClientResponse, VisionMeetingRoom } from './types';
import { formatClientTime } from './utils';

export const useClientSide = () => {
  const { token } = useSelector((state: State) => state.main.user);

  const [isLoading, setIsLoading] = useState<boolean>(true);

  const [reception, setReception] = useState<VisionClientResponse[]>([]);
  const [meetingRooms, setMeetingRooms] = useState<VisionMeetingRoom[]>([]);
  const [notaryRooms, setNotaryRooms] = useState<VisionMeetingRoom[]>([]);

  const emptyRoomClients = useMemo(() => reception.map((client) => ({
    id: client.card_id,
    time: formatClientTime(client.start_time),
    developer: '???',
    name: client.buyer[0].title,
    onCall: (roomId: number) => {
      const currentRoomIndex = meetingRooms.findIndex(({ id }) => roomId === id);

      if (currentRoomIndex < 0) throw new Error(`Can't find room with id: ${roomId}`);

      meetingRooms[currentRoomIndex].client = client;
      setMeetingRooms([...meetingRooms]);
      setReception(reception.filter(({ card_id }) => card_id !== client.card_id));
    }
  })), [reception, meetingRooms]);

  useEffect(() => {
    (async () => {
      if (token) {
        const [
          reception,
          meetingRooms,
          notaryRooms,
        ] = await loadSpaceInfo(token);

        setReception(reception || []);
        setMeetingRooms(meetingRooms || []);
        setNotaryRooms(notaryRooms || []);
        setIsLoading(false);
      }
    })();
  }, [token]);

  return {
    isLoading,
    reception,
    meetingRooms,
    notaryRooms,
    emptyRoomClients,
  };
};
