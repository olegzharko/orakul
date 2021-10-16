import { data } from 'jquery';
import { useSelector, useDispatch } from 'react-redux';
import { useEffect, useState, useCallback } from 'react';
import { useParams } from 'react-router-dom';

import { State } from '../../../../../../../../../../../store/types';
import getMainData from '../../../../../../../../../../../services/generator/Main/getMainData';
import createContract from '../../../../../../../../../../../services/generator/Main/createContract';
import { setModalInfo } from '../../../../../../../../../../../store/main/actions';
import reqImmovableExchange from '../../../../../../../../../../../services/generator/Immovable/reqImmovableExchange';

export const useGeneratorMain = () => {
  const dispatch = useDispatch();
  const { lineItemId } = useParams<{lineItemId: string}>();
  const { token } = useSelector((state: State) => state.main.user);

  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [title, setTitle] = useState<string>('');
  const [code, setCode] = useState<string>('');
  const [instructions, setInstructions] = useState([]);
  const [exchange, setExchange] = useState();

  const onSave = useCallback(async () => {
    if (token) {
      const res = await createContract(token, lineItemId);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );

      if (res?.success && res?.data?.link) {
        res.data.link.forEach((link: string, index: number) => {
          setTimeout(() => {
            document.location.href = link;
          }, index * 500);
        });
      }
    }
  }, [token, lineItemId, dispatch]);

  useEffect(() => {
    if (token) {
      (async () => {
        setIsLoading(true);
        const res = await getMainData(token, lineItemId);

        if (res?.success) {
          const { date, day, room, time } = res.data.date_info;
          setTitle(`${day} ${date} ${time} ${room}`);
          setCode(res.data.card_id);
          setInstructions(res.data.instructions);
        }

        setIsLoading(false);
      })();

      (async () => {
        const res = await reqImmovableExchange(token, lineItemId);

        if (res?.success) {
          setExchange(res.data);
        }
      })();
    }
  }, [token, lineItemId]);

  return {
    lineItemId,
    code,
    title,
    instructions,
    isLoading,
    exchange,
    onSave,
  };
};
