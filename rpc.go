package broadcast

type rpcService struct {
	s *Service
}

// Broadcast Messages.
func (r *rpcService) Broadcast(msg []*Message, ok *bool) error {
	*ok = true
	return r.s.Broadcast(msg...)
}

// Broadcast Messages in async mode.
func (r *rpcService) BroadcastAsync(msg []*Message, ok *bool) error {
	*ok = true
	go r.s.Broadcast(msg...)

	return nil
}
