import { useCallback, useEffect, useMemo, useState } from 'react';

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
}

export const useWaitingRoomClientTableItem = (
  { index, client, height, onClick }: WaitingRoomClientTableItemProps
) => {
  const [edit, setEdit] = useState<boolean>(false);

  const editSaveButtonTitle = useMemo(() => (edit ? 'Зберегти' : 'Редагувати'), [edit]);

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

  // People change
  const [people, setPeople] = useState<number>(client.number_of_people);

  const onPeopleIncrease = useCallback((e) => {
    setPeople(people + 1);
  }, [people]);

  const onPeopleDecrease = useCallback(() => {
    setPeople(people - 1);
  }, [people]);

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
    handleClick,
    handleClose,
    onEditSaveClick,
    onPeopleIncrease,
    onPeopleDecrease,
  };
};
