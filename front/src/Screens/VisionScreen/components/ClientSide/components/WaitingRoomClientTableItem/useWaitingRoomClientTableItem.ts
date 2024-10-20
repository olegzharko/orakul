import { useCallback, useEffect, useMemo, useState } from 'react';
import { useHistory } from 'react-router';

import routes from '../../../../../../routes';
import { PostDealUpdate } from '../../../../../../services/vision/space/postDealUpdate';

import { getWaitingTime } from '../../../../utils';

import { VisionClientResponse } from '../../types';

export const DEFAULT_DURATION = 500;

export enum RoundColor {
  'true' = '#04BC00',
  'false' = '#C4C4C4',
  'undefined' = '#C4C4C4',
}

export type WaitingRoomClientTableItemProps = {
  height: number | string;
  index: number;
  client: VisionClientResponse;
  onClick: (index: number) => void;
  onFinish: (cardId: number) => void;
  onSave: (updatedData: PostDealUpdate) => void;
}

export const useWaitingRoomClientTableItem = (
  {
    index,
    client,
    height,
    onClick,
    onFinish,
    onSave,
  }: WaitingRoomClientTableItemProps
) => {
  const history = useHistory();

  // State
  const [edit, setEdit] = useState<boolean>(false);
  const [waitingTime, setWaitingTime] = useState<string>(getWaitingTime(client.visit_time));

  // Memo
  const editSaveButtonTitle = useMemo(() => (edit ? 'Зберегти' : 'Редагувати'), [edit]);

  // People change
  const [people, setPeople] = useState<number>(client.number_of_people);

  const onPeopleIncrease = useCallback((e) => {
    setPeople(people + 1);
  }, [people]);

  const onPeopleDecrease = useCallback(() => {
    setPeople(people - 1);
  }, [people]);

  // Children change
  const [children, setChildren] = useState<boolean>(client.children);

  const onChildrenChange = useCallback(() => {
    setChildren(!children);
  }, [children]);

  // Callbacks
  const handleClick = useCallback(() => {
    if (edit) return;

    onClick(index);
  }, [onClick, index, edit]);

  const handleClose = useCallback(() => {
    onClick(-1);
  }, [onClick]);

  const onEditSaveClick = useCallback(async () => {
    try {
      if (edit) {
        await onSave({
          card_id: client.card_id,
          number_of_people: people,
          children
        });
      }
      setEdit(!edit);
    } catch (e: any) {
      console.error(e);
    }
  }, [children, client.card_id, edit, onSave, people]);

  const onMoreClick = useCallback(() => {
    history.push(routes.vision.clientSideRoom.linkTo(client.deal_id));
  }, [client.deal_id, history]);

  const onFinishClick = useCallback(() => {
    onFinish(client.deal_id);
  }, [client.deal_id, onFinish]);

  // Effects
  useEffect(() => {
    if (!height) {
      setEdit(false);
    }

    setPeople(client.number_of_people);
    setChildren(client.children);
  }, [client.children, client.number_of_people, height]);

  useEffect(() => {
    setInterval(() => setWaitingTime(getWaitingTime(client.visit_time)), 1000);
  }, [client.visit_time]);

  return {
    client,
    height,
    edit,
    editSaveButtonTitle,
    people,
    children,
    waitingTime,
    handleClick,
    handleClose,
    onEditSaveClick,
    onPeopleIncrease,
    onPeopleDecrease,
    onChildrenChange,
    onMoreClick,
    onFinishClick,
  };
};
