import React from 'react';
import './index.scss';
import MModal from '@material-ui/core/Modal';
import Backdrop from '@material-ui/core/Backdrop';
import Fade from '@material-ui/core/Fade';

type Props = {
  open: boolean;
  handleClose: () => void;
  success: boolean;
  message: string;
};

// eslint-disable-next-line prettier/prettier
const RequestModal = ({
  open, handleClose, success, message
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
    <Fade in={open}>
      <div className={`modal ${success ? 'modal-success' : 'modal-failed'}`}>
        <p className="message">{message}</p>
      </div>
    </Fade>
  </MModal>
);

export default RequestModal;
