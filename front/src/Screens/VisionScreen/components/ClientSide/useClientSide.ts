import { useCallback, useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';

import { State } from '../../../../store/types';

import { loadSpaceInfo } from './actions';
import { VisionClientResponse, VisionMeetingRoom, VisionNotaryRoom } from './types';
import { formatClientTime } from './utils';

export const useClientSide = () => {
  const { token } = useSelector((state: State) => state.main.user);

  // State
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [reception, setReception] = useState<VisionClientResponse[]>([]);
  const [meetingRooms, setMeetingRooms] = useState<VisionMeetingRoom[]>([]);
  const [notaryRooms, setNotaryRooms] = useState<VisionNotaryRoom[]>([]);

  // Memo
  const emptyRoomClients = useMemo(() => reception.map((client) => ({
    id: client.card_id,
    time: formatClientTime(client.start_time),
    developer: '???',
    name: client.buyer[0]?.title,
    color: client.color,
    notary_id: client.notary_id,
    onCall: (roomId: number, isNotary?: boolean) => {
      if (isNotary) {
        const currentNotaryRoomIndex = notaryRooms.findIndex(
          ({ notary_id }) => notary_id === client.notary_id
        );

        if (currentNotaryRoomIndex < 0) throw new Error(`Notary with id: ${client.notary_id} was not found`);

        notaryRooms[currentNotaryRoomIndex].client = client;
        setNotaryRooms([...notaryRooms]);
      } else {
        const currentRoomIndex = meetingRooms.findIndex(({ id }) => roomId === id);

        if (currentRoomIndex < 0) throw new Error(`Can't find room with id: ${roomId}`);

        meetingRooms[currentRoomIndex].client = client;
        setMeetingRooms([...meetingRooms]);
      }

      setReception(reception.filter(({ card_id }) => card_id !== client.card_id));
    }
  })), [reception, meetingRooms, notaryRooms]);

  // Callbacks
  const onReceptionClientFinish = useCallback((cardId: number) => {
    const cardIndex = reception.findIndex(({ card_id }) => card_id === cardId);
    reception.splice(cardIndex, 1);
    setReception([...reception]);
  }, [reception]);

  const onRoomClientToReception = useCallback((roomId: number, client: VisionClientResponse) => {
    const currentMeetingRoomIndex = meetingRooms.findIndex(({ id }) => roomId === id);
    meetingRooms[currentMeetingRoomIndex].client = undefined;

    setMeetingRooms([...meetingRooms]);
    setReception([...reception, client]);
  }, [reception, meetingRooms]);

  const onRoomClientFinish = useCallback((roomId: number) => {
    const roomIndex = meetingRooms.findIndex(({ id }) => id === roomId);
    meetingRooms[roomIndex].client = undefined;
    setMeetingRooms([...meetingRooms]);
  }, [meetingRooms]);

  const onRoomClientToNotary = useCallback((roomId: number, client: VisionClientResponse) => {
    const currentNotaryRoomIndex = notaryRooms.findIndex(
      ({ notary_id }) => notary_id === client.notary_id
    );

    if (currentNotaryRoomIndex < 0) throw new Error(`Notary with id: ${client.notary_id} was not found`);

    if (notaryRooms[currentNotaryRoomIndex]?.client) {
      // eslint-disable-next-line no-alert
      alert(`В кабінеті ${notaryRooms[currentNotaryRoomIndex]?.title || 'нотаріуса'} вже є клієнт`);
      return;
    }

    notaryRooms[currentNotaryRoomIndex].client = client;
    setNotaryRooms([...notaryRooms]);

    const currentMeetingRoomIndex = meetingRooms.findIndex(({ id }) => roomId === id);
    meetingRooms[currentMeetingRoomIndex].client = undefined;
    setMeetingRooms([...meetingRooms]);
  }, [meetingRooms, notaryRooms]);

  const onNotaryClientToReception = useCallback((roomId: number, client: VisionClientResponse) => {
    const currentNotaryRoomIndex = notaryRooms.findIndex(({ id }) => roomId === id);
    notaryRooms[currentNotaryRoomIndex].client = undefined;

    setNotaryRooms([...notaryRooms]);
    setReception([...reception, client]);
  }, [notaryRooms]);

  const onNotaryClientFinish = useCallback((roomId: number) => {
    const roomIndex = notaryRooms.findIndex(({ id }) => id === roomId);
    notaryRooms[roomIndex].client = undefined;
    setNotaryRooms([...notaryRooms]);
  }, [notaryRooms]);

  // Effects
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
    onReceptionClientFinish,
    onRoomClientToReception,
    onRoomClientFinish,
    onRoomClientToNotary,
    onNotaryClientToReception,
    onNotaryClientFinish,
  };
};
