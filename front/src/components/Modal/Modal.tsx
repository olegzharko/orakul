import React, { ReactElement } from 'react';
import MModal from '@material-ui/core/Modal';
import Backdrop from '@material-ui/core/Backdrop';
import Fade from '@material-ui/core/Fade';

type Props = {
  open: boolean;
  handleClose: () => void;
  children: ReactElement;
};

const Modal = ({
  open, handleClose, children
}: Props) => (
  <MModal
    className="modal-container"
    open={open}
    onClose={handleClose}
    closeAfterTransition
    BackdropComponent={Backdrop}
    BackdropProps={{
      timeout: 500,
    }}
  >
    <Fade in={open}>{children}</Fade>
  </MModal>
);

export default Modal;
