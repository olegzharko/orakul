import { Button, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle } from '@material-ui/core';
import React from 'react';

type Props = {
  open: boolean;
  handleClose: () => void;
  handleConfirm: () => void;
  title: string;
  message: string;
}

const ConfirmDialog = ({ open, handleClose, handleConfirm, title, message }: Props) => (
  <Dialog
    open={open}
    onClose={handleClose}
    aria-labelledby="alert-dialog-title"
    aria-describedby="alert-dialog-description"
  >
    <DialogTitle>{title}</DialogTitle>
    <DialogContent>
      <DialogContentText>{message}</DialogContentText>
    </DialogContent>
    <DialogActions>
      <Button onClick={handleClose} color="primary">
        Закрити
      </Button>
      <Button onClick={handleConfirm} color="primary" autoFocus>
        Підтвердити
      </Button>
    </DialogActions>
  </Dialog>
);

export default ConfirmDialog;
