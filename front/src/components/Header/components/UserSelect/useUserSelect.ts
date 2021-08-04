import { useCallback, useState, useMemo } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useHistory } from 'react-router-dom';
import { setUserTypeAction } from '../../../../store/main/actions';
import { State } from '../../../../store/types';
import { UserTypes } from '../../../../types';

export const useUserSelect = () => {
  const dispatch = useDispatch();
  const history = useHistory();

  const [isOpen, setIsOpen] = useState<boolean>(false);
  const extra_type = useSelector((state: State) => state.main.user.extra_type);
  const userType = useSelector((state: State) => state.main.user.type);

  const handleOpen = useCallback(() => {
    setIsOpen(true);
  }, []);

  const handleClose = useCallback(() => {
    setIsOpen(false);
  }, []);

  const handleUserType = useCallback((type: UserTypes) => {
    setIsOpen(false);
    history.push('/');
    dispatch(setUserTypeAction(type));
  }, []);

  const userTypeButtons = useMemo(() => (
    extra_type
      .filter(({ type }) => type !== userType)
      .map(({ title, type }) => ({
        label: title,
        onClick: () => handleUserType(type),
      }))
  ), [extra_type, userType]);

  return {
    isOpen,
    userTypeButtons,
    handleOpen,
    handleClose,
  };
};
