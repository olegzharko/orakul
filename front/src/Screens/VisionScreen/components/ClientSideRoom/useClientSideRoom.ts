import { useEffect, useState } from 'react';
import { useSelector } from 'react-redux';
import { useParams } from 'react-router-dom';

import getDealDetail from '../../../../services/vision/space/getDealDetail';
import { State } from '../../../../store/types';

import {
  ClientSideRoomImmovable,
  ClientSideRoomRepresentative,
  ClientSideRoomPayment,
  ClientSideRoomStage,
  ClientSideRoomTime,
  ClientSideRoomOther,
} from './types';

export const useClientSideRoom = () => {
  const { token } = useSelector((state: State) => state.main.user);
  const { dealId } = useParams<{dealId: string}>();

  // State
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [header, setHeader] = useState<{title: string, color: string}>({
    title: '',
    color: '',
  });
  const [time, setTime] = useState<ClientSideRoomTime[]>();
  const [representative, setRepresentative] = useState<ClientSideRoomRepresentative[]>([]);
  const [immovables, setImmovables] = useState<ClientSideRoomImmovable[]>([]);
  const [other, setOther] = useState<ClientSideRoomOther[]>();
  const [payments, setPayments] = useState<ClientSideRoomPayment>();
  const [stages, setStages] = useState<ClientSideRoomStage[]>([]);

  // Effects
  useEffect(() => {
    (async () => {
      if (!token) return;
      try {
        const res = await getDealDetail(token, dealId);

        setTime(res?.time);
        setRepresentative(res?.dev_representative);
        setImmovables(res?.immovable);
        setOther(res?.info);
        setPayments(res?.payment);
        setStages(res?.steps_list);
        setHeader({
          title: res?.room,
          color: res?.color
        });
      } catch (e: any) {
        alert(e.message);
        console.error(e);
      } finally {
        setIsLoading(false);
      }
    })();
  }, [dealId, token]);

  return {
    isLoading,
    header,
    time,
    representative,
    immovables,
    other,
    payments,
    stages,
  };
};
