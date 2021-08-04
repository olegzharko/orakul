import React, { useState, useCallback } from 'react';
import Modal from '../../../Modal';
import PrimaryButton from '../../../PrimaryButton';
import './index.scss';
import { useUserSelect } from './useUserSelect';

const UserSelect = () => {
  const {
    isOpen,
    userTypeButtons,
    handleOpen,
    handleClose,
  } = useUserSelect();

  if (!userTypeButtons.length) return null;

  return (
    <div className="user-select">
      <img src="/images/user.svg" alt="user" onClick={handleOpen} />
      <Modal
        open={isOpen}
        handleClose={handleClose}
      >
        <div className="user-select__modal">
          {
            userTypeButtons.map(({ label, onClick }) => (
              <PrimaryButton
                key={label}
                label={label}
                onClick={onClick}
                className="user-select__button"
              />
            ))
          }

        </div>
      </Modal>
    </div>
  );
};

export default UserSelect;
