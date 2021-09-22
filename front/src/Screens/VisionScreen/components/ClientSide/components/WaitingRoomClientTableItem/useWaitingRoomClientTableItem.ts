import { useCallback, useEffect, useMemo, useState } from 'react';
import { useHistory } from 'react-router';
import { VisionNavigationLinks } from '../../../../enums';

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
}

export const useWaitingRoomClientTableItem = (
  {
    index,
    client,
    height,
    onClick,
    onFinish
  }: WaitingRoomClientTableItemProps
) => {
  const history = useHistory();

  // State
  const [edit, setEdit] = useState<boolean>(false);

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

  const onEditSaveClick = useCallback(() => {
    setEdit(!edit);
  }, [edit]);

  const onMoreClick = useCallback(() => {
    history.push(`${VisionNavigationLinks.clientSide}/${client.card_id}`);
  }, [client]);

  const onFinishClick = useCallback(() => {
    onFinish(client.card_id);
  }, []);

  // Effects
  useEffect(() => {
    if (!height) {
      setEdit(false);
    }
  }, [height]);

  return {
    client,
    height,
    edit,
    editSaveButtonTitle,
    people,
    children,
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
