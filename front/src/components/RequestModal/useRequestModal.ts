/* eslint-disable implicit-arrow-linebreak */
import { useMemo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { setModalInfo } from '../../store/main/actions';
import { State } from '../../store/types';

export const useRequestModal = () => {
  const dispatch = useDispatch();
  const { modalInfo } = useSelector((state: State) => state.main);

  const modalProps = useMemo(
    () => ({
      ...modalInfo,
      handleClose: () =>
        dispatch(
          setModalInfo({
            ...modalInfo,
            open: false,
          })
        ),
    }),
    [dispatch, modalInfo]
  );

  return modalProps;
};
