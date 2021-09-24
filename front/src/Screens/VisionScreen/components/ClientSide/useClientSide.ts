import { useCallback, useEffect, useMemo, useState } from 'react';
import { useSelector } from 'react-redux';

import postDealUpdate, { PostDealUpdate } from '../../../../services/vision/space/postDealUpdate';
import postMoveToNotary from '../../../../services/vision/space/postMoveToNotary';
import postMoveToRoom from '../../../../services/vision/space/postMoveToRoom';
import postMoveToReception from '../../../../services/vision/space/postMoveToReception';
import { State } from '../../../../store/types';

import { loadSpaceInfo } from './actions';
import { VisionClientResponse, VisionMeetingRoom, VisionNotaryRoom } from './types';
import { formatClientTime } from './utils';
import postDealClose from '../../../../services/vision/space/postDealClose';

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
    developer: client.invite_room_title,
    name: client.buyer[0]?.title,
    color: client.color,
    notary_id: client.notary_id,
    onCall: async (roomId: number, isNotary?: boolean) => {
      if (!token) return;
      if (isNotary) {
        try {
          await postMoveToNotary(token, client.deal_id);

          const currentNotaryRoomIndex = notaryRooms.findIndex(
            ({ notary_id }) => notary_id === client.notary_id
          );

          if (currentNotaryRoomIndex < 0) throw new Error(`Notary with id: ${client.notary_id} was not found`);

          notaryRooms[currentNotaryRoomIndex].client = client;
          setNotaryRooms([...notaryRooms]);
          setReception(reception.filter(({ card_id }) => card_id !== client.card_id));
        } catch (e: any) {
          alert(e.message);
          console.error(e);
        }
      } else {
        try {
          await postMoveToRoom(token, client.deal_id, roomId);
          const currentRoomIndex = meetingRooms.findIndex(({ id }) => roomId === id);

          if (currentRoomIndex < 0) throw new Error(`Can't find room with id: ${roomId}`);

          meetingRooms[currentRoomIndex].client = client;
          setMeetingRooms([...meetingRooms]);
          setReception(reception.filter(({ card_id }) => card_id !== client.card_id));
        } catch (e: any) {
          alert(e.message);
          console.error(e);
        }
      }
    }
  })), [reception, token, notaryRooms, meetingRooms]);

  // Callbacks
  const onReceptionDealUpdate = useCallback(async (updatedData: PostDealUpdate) => {
    if (!token) return;

    await postDealUpdate(token, updatedData);
  }, [token]);

  const onRoomClientToReception = useCallback(async (
    roomId: number,
    client: VisionClientResponse,
  ) => {
    if (!token) return;

    try {
      await postMoveToReception(token, client.deal_id);

      const currentMeetingRoomIndex = meetingRooms.findIndex(({ id }) => roomId === id);
      meetingRooms[currentMeetingRoomIndex].client = undefined;

      setMeetingRooms([...meetingRooms]);
      setReception([...reception, client]);
    } catch (e: any) {
      alert(e.message);
      console.error(e);
    }
  }, [token, meetingRooms, reception]);

  const onRoomClientToNotary = useCallback(async (roomId: number, client: VisionClientResponse) => {
    if (!token) return;

    try {
      await postMoveToNotary(token, client.deal_id);

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
    } catch (err: any) {
      alert(err.message);
      console.error(err);
    }
  }, [meetingRooms, notaryRooms, token]);

  const onNotaryClientToReception = useCallback(async (
    roomId: number,
    client: VisionClientResponse,
  ) => {
    if (!token) return;

    try {
      await postMoveToReception(token, client.deal_id);

      const currentNotaryRoomIndex = notaryRooms.findIndex(({ id }) => roomId === id);
      notaryRooms[currentNotaryRoomIndex].client = undefined;

      setNotaryRooms([...notaryRooms]);
      setReception([...reception, client]);
    } catch (e: any) {
      alert(e.message);
      console.error(e);
    }
  }, [notaryRooms, reception, token]);

  const onReceptionClientFinish = useCallback(async (dealId: number) => {
    if (!token) return;

    try {
      await postDealClose(token, dealId);

      const cardIndex = reception.findIndex(({ deal_id }) => deal_id === dealId);
      reception.splice(cardIndex, 1);
      setReception([...reception]);
    } catch (e: any) {
      alert(e.message);
      console.error(e);
    }
  }, [reception, token]);

  const onRoomClientFinish = useCallback(async (dealId: number) => {
    if (!token) return;

    try {
      await postDealClose(token, dealId);

      const roomIndex = meetingRooms.findIndex(({ client }) => client?.deal_id === dealId);
      meetingRooms[roomIndex].client = undefined;
      setMeetingRooms([...meetingRooms]);
    } catch (e: any) {
      alert(e.message);
      console.error(e);
    }
  }, [meetingRooms, token]);

  const onNotaryClientFinish = useCallback(async (dealId: number) => {
    if (!token) return;

    try {
      await postDealClose(token, dealId);

      const roomIndex = notaryRooms.findIndex(({ client }) => client?.deal_id === dealId);
      notaryRooms[roomIndex].client = undefined;
      setNotaryRooms([...notaryRooms]);
    } catch (e: any) {
      alert(e.message);
      console.error(e);
    }
  }, [notaryRooms, token]);

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
    onReceptionDealUpdate,
  };
};
